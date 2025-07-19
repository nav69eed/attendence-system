<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

    // Task Routes
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::post('/tasks/{task}/submit', [TaskController::class, 'submit'])->name('tasks.submit');

    // Admin Task Routes
    Route::get('/admin/tasks', [TaskController::class, 'adminIndex'])
        ->name('admin.tasks.index')
        ->middleware('role:admin');
    Route::get('/admin/tasks/create', [TaskController::class, 'create'])
        ->name('admin.tasks.create')
        ->middleware('role:admin');
    Route::post('/admin/tasks', [TaskController::class, 'store'])
        ->name('admin.tasks.store')
        ->middleware('role:admin');
    Route::get('/admin/tasks/{task}', [TaskController::class, 'show'])
        ->name('admin.tasks.show')
        ->middleware('role:admin');
    Route::get('/admin/tasks/{task}/edit', [TaskController::class, 'edit'])
        ->name('admin.tasks.edit')
        ->middleware('role:admin');
    Route::delete('/admin/tasks/{task}', [TaskController::class, 'destroy'])
        ->name('admin.tasks.destroy')
        ->middleware('role:admin');
    Route::get('/admin/tasks/{task}/submissions', [TaskController::class, 'viewSubmissions'])
        ->name('admin.tasks.submissions')
        ->middleware('role:admin');
});

// ✅ Load auth routes properly here
require __DIR__ . '/auth.php';
