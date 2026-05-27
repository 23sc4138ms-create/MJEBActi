<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\UserAccount;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = trim((string) $request->query('search', ''));

        try {
            $studentQuery = Student::with(['degree', 'userAccount']);

            if ($searchTerm !== '') {
                $studentQuery->where(function ($query) use ($searchTerm) {
                    $query->where('fname', 'like', "%{$searchTerm}%")
                        ->orWhere('lname', 'like', "%{$searchTerm}%")
                        ->orWhere('mname', 'like', "%{$searchTerm}%")
                        ->orWhere('email', 'like', "%{$searchTerm}%")
                        ->orWhere('contact_no', 'like', "%{$searchTerm}%")
                        ->orWhereHas('degree', function ($degreeQuery) use ($searchTerm) {
                            $degreeQuery->where('title', 'like', "%{$searchTerm}%");
                        });
                });
            }

            $students = $studentQuery->paginate(10)->appends($request->only('search'));
        } catch (\Throwable $exception) {
            Log::error('Unable to load students list due to database connection issue.', [
                'error' => $exception->getMessage(),
            ]);

            $students = new LengthAwarePaginator(
                collect(),
                0,
                10,
                (int) $request->query('page', 1),
                [
                    'path' => $request->url(),
                    'query' => $request->query(),
                ]
            );

            $errorMessage = 'Database connection failed. Please start MySQL and try again.';

            if ($request->ajax() && $request->boolean('table')) {
                return view('students.partials.table', ['students' => $students])
                    ->with('error', $errorMessage);
            }

            return view('students.index', ['students' => $students])
                ->with('error', $errorMessage);
        }

        if ($request->ajax() && $request->boolean('table')) {
            return view('students.partials.table', ['students' => $students]);
        }

        return view('students.index', ['students' => $students]);
    }

    public function home()
    {
        return view('clientDashboard');
    }

    public function about()
    {
        return view('clientAboutUs');
    }

    public function create()
    {
        $degrees = \App\Models\Degree::all();
        return view('students.create', ['degrees' => $degrees]);
    }

    public function store(Request $request)
    {
        $rules = [
            'fname' => 'required|min:2',
            'mname' => 'required|string|max:1',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:students,email|unique:user_accounts,email',
            'contact_no' => 'required|digits:11',
            'username' => 'required|min:3|unique:user_accounts,username',
            'password' => 'required|min:6',
            'degree_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $student = DB::transaction(function () use ($request) {
                $accountData = [
                    'username' => $request->input('username'),
                    'email' => $request->input('email'),
                    'password' => Hash::make($request->input('password')),
                    'role' => 'student',
                    'is_active' => 1,
                ];

                if (Schema::hasColumn('user_accounts', 'must_change_password')) {
                    $accountData['must_change_password'] = true;
                }

                $userAccount = UserAccount::create($accountData);

                return Student::create([
                    'user_account_id' => $userAccount->id,
                    'fname' => $request->input('fname'),
                    'mname' => $request->input('mname'),
                    'lname' => $request->input('lname'),
                    'email' => $request->input('email'),
                    'contact_no' => $request->input('contact_no'),
                    'degree_id' => $request->input('degree_id'),
                ]);
            });
        } catch (\Throwable $exception) {
            Log::error('Student creation failed', [
                'error' => $exception->getMessage(),
            ]);

            $failureMessage = 'Unable to create student. Please check your inputs and try again.';

            if ($request->expectsJson()) {
                return response()->json(['error' => $failureMessage], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => $failureMessage])
                ->withInput();
        }

        Log::info('Student created successfully', [
            'student_id' => $student->id,
            'student_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'email' => $student->email,
            'contact_no' => $student->contact_no,
            'degree' => $student->degree?->title ?? 'N/A',
            'degree_id' => $student->degree_id,
            'timestamp' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student created successfully',
                'student' => $student,
                'redirect_url' => route('students.index'),
            ], 201);
        }

        return redirect()->route('students.index')->with('success', 'Student created successfully');
    }

    public function show(string $id)
    {
        $student = Student::with(['degree', 'userAccount'])->find($id);

        if (!$student) {
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        return view('students.show', ['student' => $student]);
    }

    public function edit(string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return redirect()->route('students.index')
                           ->with('error', 'Student not found!');
        }

        $degrees = \App\Models\Degree::all();
        return view('students.edit', ['student' => $student, 'degrees' => $degrees]);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Student not found!'], 404);
            }

            return redirect('/students')->with('error', 'Student not found!');
        }

        $rules = [
            'fname' => 'required|min:2',
            'mname' => 'required|string|max:1',
            'lname' => 'required|min:2',
            'email' => 'required|email|unique:students,email,' . $id,
            'contact_no' => 'required|digits:11',
            'degree_id' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            return redirect()->back()->withErrors($validator)->withInput();
        }

        $previousDegree = $student->degree?->title ?? 'N/A';
        $previousName = $student->fname . ' ' . $student->mname . ' ' . $student->lname;
        $previousEmail = $student->email;
        $previousPhone = $student->contact_no;

        try {
            $student->update([
                'fname' => $request->input('fname'),
                'mname' => $request->input('mname'),
                'lname' => $request->input('lname'),
                'email' => $request->input('email'),
                'contact_no' => $request->input('contact_no'),
                'degree_id' => $request->input('degree_id'),
            ]);
        } catch (\Throwable $exception) {
            Log::error('Student update failed', [
                'student_id' => $id,
                'error' => $exception->getMessage(),
            ]);

            $failureMessage = 'Unable to update student. Please try again.';

            if ($request->expectsJson()) {
                return response()->json(['error' => $failureMessage], 500);
            }

            return redirect()->back()
                ->withErrors(['error' => $failureMessage])
                ->withInput();
        }

        $student->refresh();

        Log::info('Student updated successfully', [
            'student_id' => $student->id,
            'old_name' => $previousName,
            'new_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'old_email' => $previousEmail,
            'new_email' => $student->email,
            'old_phone' => $previousPhone,
            'new_phone' => $student->contact_no,
            'old_degree' => $previousDegree,
            'new_degree' => $student->degree?->title ?? 'N/A',
            'timestamp' => now(),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully',
                'student' => $student,
                'redirect_url' => route('students.index'),
            ]);
        }

        return redirect()->route('students.index')->with('message', 'Student Updated Successfully');
    }

    public function destroy(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Student not found!'], 404);
            }

            return redirect()->route('students.index')
                ->with('error', 'Not Found!');
        }

        $deletedStudentData = [
            'student_id' => $student->id,
            'student_name' => $student->fname . ' ' . $student->mname . ' ' . $student->lname,
            'email' => $student->email,
            'contact_no' => $student->contact_no,
            'degree' => $student->degree?->title ?? 'N/A',
            'degree_id' => $student->degree_id,
            'user_account_id' => $student->user_account_id,
        ];

        try {
            DB::transaction(function () use ($student) {
                $userAccountId = $student->user_account_id;

                $student->delete();

                if ($userAccountId) {
                    UserAccount::whereKey($userAccountId)->delete();
                }
            });
        } catch (\Throwable $exception) {
            Log::error('Student deletion failed', [
                'student_id' => $id,
                'error' => $exception->getMessage(),
            ]);

            $failureMessage = 'Unable to delete student. Please try again.';

            if ($request->expectsJson()) {
                return response()->json(['error' => $failureMessage], 500);
            }

            return redirect()->route('students.index')
                ->with('error', $failureMessage);
        }

        Log::warning('Student deleted', array_merge($deletedStudentData, [
            'timestamp' => now(),
        ]));

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Student deleted successfully']);
        }

        return redirect()->route('students.index')
            ->with('success', 'Student deleted successfully!');
    }
}