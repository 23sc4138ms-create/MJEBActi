<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\UserAccount;
use App\Models\Course;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function studentReport()
    {
        $students = Student::with(['degree', 'userAccount', 'courses'])->get();
        return view('admin.reports.student', compact('students'));
    }

    public function studentPdf()
    {
        $students = Student::with(['degree', 'userAccount', 'courses'])->get();
        
        $pdf = Pdf::loadView('admin.reports.student-pdf', compact('students'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('student-report-' . date('Y-m-d') . '.pdf');
    }

    public function studentExcel()
    {
        $students = Student::with(['degree', 'userAccount', 'courses'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Phone');
        $sheet->setCellValue('E1', 'Age');
        $sheet->setCellValue('F1', 'Degree');
        $sheet->setCellValue('G1', 'Course');

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '366092']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ];
        
        for ($col = 'A'; $col <= 'G'; $col++) {
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        }

        // Add data
        $row = 2;
        foreach ($students as $student) {
            $fullName = trim(implode(' ', array_filter([$student->fname, $student->mname, $student->lname])));
            $courseNames = $student->courses->pluck('course_name')->implode(', ');

            $sheet->setCellValue('A' . $row, $student->id);
            $sheet->setCellValue('B' . $row, $fullName !== '' ? $fullName : '-');
            $sheet->setCellValue('C' . $row, $student->email ?? ($student->userAccount->email ?? ''));
            $sheet->setCellValue('D' . $row, $student->contact_no ?? '');
            $sheet->setCellValue('E' . $row, $student->age ?? '');
            $sheet->setCellValue('F' . $row, $student->degree ? $student->degree->title : '');
            $sheet->setCellValue('G' . $row, $courseNames !== '' ? $courseNames : ($student->course ?? ''));
            $row++;
        }

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(8);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(20);

        $writer = new Xlsx($spreadsheet);
        $filename = 'student-report-' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        
        $writer->save('php://output');
        exit;
    }

    public function userReport()
    {
        $users = UserAccount::query()->orderBy('id')->get();
        return view('admin.reports.user', compact('users'));
    }

    public function userPdf()
    {
        $users = UserAccount::query()->orderBy('id')->get();
        
        $pdf = Pdf::loadView('admin.reports.user-pdf', compact('users'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('user-report-' . date('Y-m-d') . '.pdf');
    }

    public function userExcel()
    {
        $users = UserAccount::query()->orderBy('id')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Role');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Created At');

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '366092']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ];
        
        for ($col = 'A'; $col <= 'F'; $col++) {
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        }

        // Add data
        $row = 2;
        foreach ($users as $user) {
            $sheet->setCellValue('A' . $row, $user->id);
            $sheet->setCellValue('B' . $row, $user->username ?? '');
            $sheet->setCellValue('C' . $row, $user->email);
            $sheet->setCellValue('D' . $row, ucfirst((string) ($user->role ?? '')));
            $sheet->setCellValue('E' . $row, (int) ($user->is_active ?? 0) === 1 ? 'Active' : 'Inactive');
            $sheet->setCellValue('F' . $row, $user->created_at);
            $row++;
        }

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(8);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(14);
        $sheet->getColumnDimension('F')->setWidth(20);

        $writer = new Xlsx($spreadsheet);
        $filename = 'user-report-' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        
        $writer->save('php://output');
        exit;
    }

    public function courseReport()
    {
        $courses = Course::with('students')->get();
        return view('admin.reports.course', compact('courses'));
    }

    public function coursePdf()
    {
        $courses = Course::with('students')->get();
        
        $pdf = Pdf::loadView('admin.reports.course-pdf', compact('courses'))
            ->setPaper('a4', 'landscape');
        
        return $pdf->download('course-report-' . date('Y-m-d') . '.pdf');
    }

    public function courseExcel()
    {
        $courses = Course::with('students')->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $sheet->setCellValue('A1', 'Course ID');
        $sheet->setCellValue('B1', 'Course Name');
        $sheet->setCellValue('C1', 'Total Students');
        $sheet->setCellValue('D1', 'Created At');

        // Style headers
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '366092']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ];
        
        for ($col = 'A'; $col <= 'D'; $col++) {
            $sheet->getStyle($col . '1')->applyFromArray($headerStyle);
        }

        // Add data
        $row = 2;
        foreach ($courses as $course) {
            $sheet->setCellValue('A' . $row, $course->id);
            $sheet->setCellValue('B' . $row, $course->course_name ?? '');
            $sheet->setCellValue('C' . $row, $course->students ? count($course->students) : 0);
            $sheet->setCellValue('D' . $row, $course->created_at);
            $row++;
        }

        // Adjust column widths
        $sheet->getColumnDimension('A')->setWidth(12);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);

        $writer = new Xlsx($spreadsheet);
        $filename = 'course-report-' . date('Y-m-d') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        
        $writer->save('php://output');
        exit;
    }
}
