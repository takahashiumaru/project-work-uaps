<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\shiftController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\AdminTrainingCertificateController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;


// Page
Route::resource('users', UserController::class)->middleware('auth');
Route::resource('user-aprons', UserController::class)->middleware('auth');
Route::resource('flights', FlightController::class)->middleware('auth');
Route::resource('schedule', scheduleController::class)->middleware('auth');
Route::resource('shift', shiftController::class)->middleware('auth');

// API
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [LoginController::class, 'sendForgotPassword'])->name('forgot.password.send');
Route::post('/forgot-password/verify', [LoginController::class, 'verifyForgotPassword'])->name('forgot.password.verify');
Route::get('/forgot-password/change', [LoginController::class, 'showChangePasswordForm'])->name('change.password.form');
Route::post('/forgot-password/change', [LoginController::class, 'changePassword'])->name('change.password');

Route::get('home', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::get('document', [HomeController::class, 'document'])->name('document')->middleware('auth');
Route::get('/surat', [HomeController::class, 'generatePDF'])->name('surat.generate');
Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout')->middleware('auth');

Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change.password')->middleware('auth');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('update.password');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::post('/update-photo/{userId}', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');
Route::put('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');
Route::get('/apron', [UserController::class, 'indexApron'])->name('users.apron');
Route::get('/bge', [UserController::class, 'indexBGE'])->name('users.bge');
Route::get('/office', [UserController::class, 'indexOffice'])->name('users.office');

Route::get('/kontrak', [UserController::class, 'kontrak'])->name('users.kontrak');
Route::get('/kontrak/edit/{id}', [UserController::class, 'KontrakEdit'])->name('users.KontrakEdit');
Route::put('/kontrak/update/{user}', [UserController::class, 'KontrakUpdate'])->name('users.KontrakUpdate');

Route::get('/pas', [UserController::class, 'pas'])->name('users.pas');
Route::get('/pas/edit/{id}', [UserController::class, 'PASEdit'])->name('users.PASEdit');
Route::put('/pas/update/{user}', [UserController::class, 'PASUpdate'])->name('users.PASUpdate');

Route::get('/profile/{id}', [UserController::class, 'profile'])->name('users.profile');

Route::get('/flight/{id}/users', [HomeController::class, 'getFlightUsers']);
Route::post('/flights', [FlightController::class, 'store'])->name('flights.store');
Route::get('/flights/{id}/details', [FlightController::class, 'getDetails'])->name('flights.details');

Route::post('/schedule/auto-create', [ScheduleController::class, 'autoCreate'])->name('schedule.autoCreate');
Route::get('/schedule-now', [ScheduleController::class, 'now'])->name('schedule.now');
Route::get('/schedule/show', [ScheduleController::class, 'show'])->name('schedule.show');
Route::get('/schedule/edit/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
Route::post('/schedule/update/{userId}/{date}', [ScheduleController::class, 'update'])->name('schedule.update');
Route::post('/schedules/update-active', [ScheduleController::class, 'updateActive']);

Route::put('/shifts/{shift}', [shiftController::class, 'update'])->name('shift.update');
Route::middleware(['auth'])->group(function () {
    Route::get('/leaves/apply', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/my-leaves', [LeaveController::class, 'myLeaves'])->name('leaves.myLeaves');
    Route::get('/leaves/pengajuan', [LeaveController::class, 'pengajuan'])->name('leaves.pengajuan');
    Route::get('/leaves/approval', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/laporan', [LeaveController::class, 'laporan'])->name('leaves.laporan');
    Route::patch('leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');
    Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-certificates', [TrainingController::class, 'myCertificates'])->name('my.certificates');
});

Route::prefix('admin/training')->name('admin.training.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('certificates', AdminTrainingCertificateController::class);
});
Route::get('/training', [AdminTrainingCertificateController::class, 'index'])->name('training.index');
Route::get('/training/create', [AdminTrainingCertificateController::class, 'create'])->name('training.create');

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
});

Route::middleware(['auth'])->group(function () {
    // Rute Absensi Karyawan
    // web.php
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/camera', [AttendanceController::class, 'camera'])->name('attendance.camera');
    Route::post('/attendance/process', [AttendanceController::class, 'process'])->name('attendance.process');
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');
    Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');


    //rute absensi user
    Route::get('/attendance/reports', [AttendanceController::class, 'reportsIndex'])->name('attendance.reports');
    // Jika ada fungsi export, bisa ditambahkan di sini:
    // Route::get('/attendance/reports/export', [AttendanceController::class, 'exportReports'])->name('attendance.reports.export');
    // --- END: Rute Laporan Absensi ---
});
