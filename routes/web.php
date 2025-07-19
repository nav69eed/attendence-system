<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\AdminTaskController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Admin\SubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    // Dashboard Routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard')
        ->middleware('role:admin');

    // Student Attendance Routes
    Route::get('/attendance/mark', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance/mark', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

    // Admin Attendance Routes
    Route::get('/admin/attendance', [AttendanceController::class, 'index'])
        ->name('admin.attendance.index')
        ->middleware('permission:view attendance');

    // Leave Request Routes
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{leave}', [LeaveController::class, 'show'])->name('leaves.show');

    // Admin Leave Routes
    Route::get('/admin/leaves', [LeaveController::class, 'adminIndex'])
        ->name('admin.leaves.index')
        ->middleware('role:admin');
    Route::get('/admin/leaves/{leave}/edit', [LeaveController::class, 'edit'])
        ->name('admin.leaves.edit')
        ->middleware('role:admin');
    Route::patch('/admin/leaves/{leave}', [LeaveController::class, 'update'])
        ->name('admin.leaves.update')
        ->middleware('role:admin');
    Route::patch('/admin/leaves/{leave}', [LeaveController::class, 'updateStatus'])
        ->name('admin.leaves.update')
        ->middleware('role:admin');
    Route::get('/admin/leaves/{leave}', [LeaveController::class, 'show'])
        ->name('admin.leaves.show')
        ->middleware('role:admin');

    // Student Task Routes
    Route::middleware(['auth'])->group(function () {
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');
    });

    // Admin Task Routes
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/tasks', [AdminTaskController::class, 'index'])->name('admin.tasks.index');
        Route::get('/admin/tasks/create', [AdminTaskController::class, 'create'])->name('admin.tasks.create');
        Route::post('/admin/tasks', [AdminTaskController::class, 'store'])->name('admin.tasks.store');
        Route::get('/admin/tasks/{task}', [AdminTaskController::class, 'show'])->name('admin.tasks.show'); // Add this line
        Route::get('/admin/tasks/{task}/edit', [AdminTaskController::class, 'edit'])->name('admin.tasks.edit');
        Route::put('/admin/tasks/{task}', [AdminTaskController::class, 'update'])->name('admin.tasks.update');
        Route::delete('/admin/tasks/{task}', [AdminTaskController::class, 'destroy'])->name('admin.tasks.destroy');
        Route::patch('/admin/tasks/{task}/status', [AdminTaskController::class, 'updateSubmissionStatus'])
            ->name('admin.tasks.update-status');
    });
    Route::get('/admin/tasks/{task}/submissions', [TaskController::class, 'viewSubmissions'])
        ->name('admin.tasks.submissions')
        ->middleware('role:admin');
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::patch('/tasks/{task}/update-status', [AdminTaskController::class, 'updateStatus'])
            ->name('admin.tasks.update-status');
    });
});

// ✅ Load auth routes properly here
require __DIR__ . '/auth.php';
