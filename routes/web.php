<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PSUController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;

// Maintenance route - ALWAYS accessible
Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

// Public routes (stay accessible even during maintenance)
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login',[UserController::class, 'login'])->middleware('auth.redirect')->name('login');
Route::post('/login',[UserController::class, 'authenticate'])->name('authenticate');
Route::get('/logout',[UserController::class, 'logout'])->name('logout');

// Protected routes with maintenance middleware
Route::middleware('maintenance')->group(function () {

    // Protected routes (login required)
    Route::middleware(\App\Http\Middleware\CheckLogin::class)->group(function () {
        Route::get('/dashboard', function () {
            $role = strtolower((string) session('role'));

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'teacher' => redirect()->route('teacher.dashboard'),
                'student' => redirect()->route('student.dashboard'),
                default => redirect()->route('logout'),
            };
        })->name('home');

        Route::get('/psu/welcome', [PSUController::class, 'welcome'])->name('psu.welcome');
        Route::get('/psu/mission', [PSUController::class, 'mission'])->name('psu.mission');
        Route::get('/psu/vision', [PSUController::class, 'vision'])->name('psu.vision');
        Route::get('/psu/eoms-policy', [PSUController::class, 'EOMSPolicy'])->name('psu.eoms.policy');

        Route::get('/change-password', [UserController::class, 'changePassword'])->name('password.change');
        Route::post('/change-password', [UserController::class, 'updatePassword'])->name('password.update');

        Route::get('/greetings',[ClientController::class, 'displayGreetings']);
        Route::get('/about',[StudentController::class, 'about'])->name('about');

        Route::get('/user_profile', [PageController::class, 'userProfile'])->name('user.profile');
        Route::get('/user_posts', [PageController::class, 'userPosts']);
        Route::get('/student__courses', [PageController::class, 'studentCourse'])->name('student.courses');
        // Alias: accept single-underscore path as well to avoid 404/maintenance redirect
        Route::get('/student_courses', [PageController::class, 'studentCourse'])->name('student.courses.alt');
        Route::get('/enrolled-students', [PageController::class, 'enrolledStudents']);
        Route::get('/setup-test-data', [PageController::class, 'setupTestData']);
        // Role-based dashboard routes
        Route::middleware('role:student')->group(function () {
            Route::get('/student-dashboard', [UserController::class, 'studentDashboard'])->name('student.dashboard');
        });

        Route::middleware('role:teacher')->group(function () {
            Route::get('/teacher-dashboard', [UserController::class, 'teacherDashboard'])->name('teacher.dashboard');
            Route::get('/teacher-courses', [UserController::class, 'teacherCourses'])->name('teacher.courses');
            Route::get('/teacher-students', [UserController::class, 'teacherStudents'])->name('teacher.students');
            Route::get('/teacher-grades', [UserController::class, 'teacherGrades'])->name('teacher.grades');
        });

        Route::middleware('role:admin')->group(function () {
            Route::get('/admin-dashboard', [UserController::class, 'adminDashboard'])->name('admin.dashboard');
            Route::get('/logs', [PageController::class, 'logs'])->name('logs');

            Route::resource('students', StudentController::class);
            Route::resource('degrees', DegreeController::class);

            Route::get('/admin/add-student', [UserController::class, 'showAddStudentForm'])->name('admin.add.student');
            Route::post('/admin/store-student', [UserController::class, 'storeStudent'])->name('admin.store.student');
            Route::get('/admin/add-teacher', [UserController::class, 'showAddTeacherForm'])->name('admin.add.teacher');
            Route::post('/admin/store-teacher', [UserController::class, 'storeTeacher'])->name('admin.store.teacher');

            // Report routes
            Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
            Route::get('/admin/reports/student', [ReportController::class, 'studentReport'])->name('admin.reports.student');
            Route::get('/admin/reports/student/pdf', [ReportController::class, 'studentPdf'])->name('admin.reports.student.pdf');
            Route::get('/admin/reports/student/excel', [ReportController::class, 'studentExcel'])->name('admin.reports.student.excel');
            Route::get('/admin/reports/user', [ReportController::class, 'userReport'])->name('admin.reports.user');
            Route::get('/admin/reports/user/pdf', [ReportController::class, 'userPdf'])->name('admin.reports.user.pdf');
            Route::get('/admin/reports/user/excel', [ReportController::class, 'userExcel'])->name('admin.reports.user.excel');
            Route::get('/admin/reports/course', [ReportController::class, 'courseReport'])->name('admin.reports.course');
            Route::get('/admin/reports/course/pdf', [ReportController::class, 'coursePdf'])->name('admin.reports.course.pdf');
            Route::get('/admin/reports/course/excel', [ReportController::class, 'courseExcel'])->name('admin.reports.course.excel');
        });


    });

    // If user types any other URL, force redirect (security)
    Route::fallback(function () {
        if (!session('user_id')) {
            return view('loginPage', ['isLocked' => false, 'lockSecondsLeft' => null]);
        }

        return redirect()->route('home');
    });

});