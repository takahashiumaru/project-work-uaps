<?php

use Illuminate\Support\Facades\Route;

// --- DAFTAR SEMUA CONTROLLER DI SINI ---
use App\Http\Controllers\OvertimeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\BlacklistController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\AdminTrainingCertificateController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ReportController;
use App\Models\Blacklist;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// =================================================================
// 1. GUEST ROUTES (LOGIN, OTP, LUPA PASSWORD)
// =================================================================
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('actionlogin', [LoginController::class, 'actionlogin'])->name('actionlogin');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// OTP
Route::get('/verify-otp', [LoginController::class, 'showOtpForm'])->name('verify.otp.form');
Route::post('/verify-otp', [LoginController::class, 'verifyOtp'])->name('verify.otp');
Route::post('/resend-otp', [LoginController::class, 'resendOtp'])->name('resend.otp');

// Forgot Password
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [LoginController::class, 'sendForgotPassword'])->name('forgot.password.send');
Route::post('/forgot-password/verify', [LoginController::class, 'verifyForgotPassword'])->name('forgot.password.verify');
Route::get('/forgot-password/change', [LoginController::class, 'showChangePasswordForm'])->name('change.password.form');
Route::post('/forgot-password/change', [LoginController::class, 'changePassword'])->name('change.password');


// =================================================================
// 2. AUTH ROUTES (HARUS LOGIN DULU)
// =================================================================
Route::middleware(['auth'])->group(function () {

    // --- DASHBOARD & UMUM ---
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('document', [HomeController::class, 'document'])->name('document');
    Route::get('/surat', [HomeController::class, 'generatePDF'])->name('surat.generate');
    Route::get('actionlogout', [LoginController::class, 'actionlogout'])->name('actionlogout');

    // Change Password & Profile Picture
    Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('change.password');
    Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('update.password');
    Route::post('/update-photo/{userId}', [UserController::class, 'updatePhoto'])->name('user.updatePhoto');
    Route::get('/profile/{id}', [UserController::class, 'profile'])->name('users.profile');

    // --- USER MANAGEMENT (CRUD) ---
    Route::resource('users', UserController::class);
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::put('/reset-password/{id}', [UserController::class, 'resetPassword'])->name('user.resetPassword');

    // Kontrak User
    Route::get('/kontrak', [UserController::class, 'kontrak'])->name('users.kontrak');
    Route::get('/kontrak/edit/{id}', [UserController::class, 'KontrakEdit'])->name('users.KontrakEdit');
    Route::put('/kontrak/update/{user}', [UserController::class, 'KontrakUpdate'])->name('users.KontrakUpdate');

    // PAS Bandara User
    Route::get('/pas', [UserController::class, 'pas'])->name('users.pas');
    Route::get('/pas/edit/{id}', [UserController::class, 'PASEdit'])->name('users.PASEdit');
    Route::put('/pas/update/{user}', [UserController::class, 'PASUpdate'])->name('users.PASUpdate');

    // --- MONITORING STAFF (IMPORT/EXPORT) ---
    // Pastikan StaffController sudah dibuat dan di-import di atas
    Route::get('/staff-data', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/export', [StaffController::class, 'export'])->name('staff.export');
    Route::post('/staff/import', [StaffController::class, 'import'])->name('staff.import');
    Route::get('/staff/template', [StaffController::class, 'template'])->name('staff.template');

    Route::get('/blacklist-data', [BlacklistController::class, 'index'])->name('blacklist.index');

    // switch on off staff
    Route::post('/staff/toggle/{id}', [StaffController::class, 'toggleStatus'])->name('staff.toggle');

    // --- STATION MANAGEMENT (KILL SWITCH) ---
    Route::get('/stations', [StationController::class, 'index'])->name('stations.index');
    Route::get('/stations/create', [StationController::class, 'create'])->name('stations.create');
    Route::post('/stations/store', [StationController::class, 'store'])->name('stations.store');
    Route::post('/stations/toggle/{id}', [StationController::class, 'toggleStatus'])->name('stations.toggle');

    // --- FLIGHTS ---
    Route::resource('flights', FlightController::class);
    Route::post('/flights', [FlightController::class, 'store'])->name('flights.store'); // Override resource store if needed?
    Route::get('/flights/{id}/details', [FlightController::class, 'getDetails'])->name('flights.details');
    Route::get('/flight/{id}/users', [HomeController::class, 'getFlightUsers']);

    // --- SCHEDULES ---
    Route::resource('schedule', ScheduleController::class); // Perbaikan typo 'scheduleController'
    Route::get('/schedule-now', [ScheduleController::class, 'now'])->name('schedule.now');
    Route::get('/schedule/show', [ScheduleController::class, 'show'])->name('schedule.view'); // Hati-hati conflict dgn resource show
    Route::post('/schedule/auto-create', [ScheduleController::class, 'autoCreate'])->name('schedule.autoCreate');
    Route::get('/schedule/edit/{id}', [ScheduleController::class, 'edit'])->name('schedule.edit');
    Route::post('/schedule/update/{userId}/{date}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::post('/schedules/update-active', [ScheduleController::class, 'updateActive']);

    // Freelance Schedule
    Route::get('/schedule-freelances', [ScheduleController::class, 'freelances'])->name('schedule.freelances');
    Route::get('/schedule-freelance-create', [ScheduleController::class, 'freelanceCreate'])->name('freelance.create');
    Route::post('/schedule-freelance-create', [ScheduleController::class, 'store'])->name('freelance.store');

    // --- SHIFTS ---
    Route::resource('shift', ShiftController::class);
    Route::put('/shifts/{shift}', [ShiftController::class, 'update'])->name('shift.update');

    // --- ATTENDANCE (ABSENSI) ---
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/camera', [AttendanceController::class, 'camera'])->name('attendance.camera'); // Jika pakai kamera
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    Route::post('/attendance/process', [AttendanceController::class, 'process'])->name('attendance.process'); // Alternatif proses
    Route::get('/attendance/history', [AttendanceController::class, 'history'])->name('attendance.history');

    // Laporan Absensi
    Route::get('/attendance/reports', [AttendanceController::class, 'reportsIndex'])->name('attendance.reports');
    Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

    // --- LEAVES (CUTI) ---
    Route::get('/leaves/apply', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/my-leaves', [LeaveController::class, 'myLeaves'])->name('leaves.myLeaves');
    Route::get('/leaves/pengajuan', [LeaveController::class, 'pengajuan'])->name('leaves.pengajuan');
    Route::get('/leaves/approval', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/laporan', [LeaveController::class, 'laporan'])->name('leaves.laporan');
    Route::patch('leaves/{leave}/status', [LeaveController::class, 'updateStatus'])->name('leaves.updateStatus');
    Route::get('/leaves/export', [LeaveController::class, 'export'])->name('leaves.export');

    // --- TRAINING & CERTIFICATES ---
    // User View
    Route::get('/my-certificates', [TrainingController::class, 'myCertificates'])->name('my.certificates');

    // Admin View
    Route::get('/training', [AdminTrainingCertificateController::class, 'index'])->name('training.index');
    Route::get('/training/create', [AdminTrainingCertificateController::class, 'create'])->name('training.create');
    Route::get('/training/edit/{certificate}', [AdminTrainingCertificateController::class, 'edit'])->name('training.edit');
    Route::delete('/training/destroy/{certificate}', [AdminTrainingCertificateController::class, 'destroy'])->name('training.destroy');

    // Admin Resource (Prefix: admin/training)
    // Note: Anda punya route manual dan resource yg tumpang tindih, saya rapikan sedikit
    Route::post('admin/training/certificates', [AdminTrainingCertificateController::class, 'store'])->name('admin.training.certificates.store');
    Route::put('admin/training/certificates/{certificate}', [AdminTrainingCertificateController::class, 'update'])->name('admin.training.certificates.update');

    // blacklist user yang udh ga kepake atau di buang
    Route::get('/blacklist', [BlacklistController::class, 'index'])->name('blacklist.index');
    Route::post('/blacklist', [BlacklistController::class, 'store'])->name('blacklist.store');
    Route::delete('/blacklist/{id}', [BlacklistController::class, 'destroy'])->name('blacklist.destroy');

    // Manajemen TIM Bandara
    Route::get('/tim', [UserController::class, 'tim'])->name('users.tim');
    Route::get('/tim/edit/{id}', [UserController::class, 'TIMEdit'])->name('users.TIMEdit');
    Route::put('/tim/update/{user}', [UserController::class, 'TIMUpdate'])->name('users.TIMUpdate');
    // --- MODUL LEMBUR (OVERTIME) ---
    Route::controller(OvertimeController::class)->group(function () {
        // Staff
        Route::get('/overtime', 'index')->name('overtime.index');
        Route::get('/overtime/create', 'create')->name('overtime.create');
        Route::post('/overtime/store', 'store')->name('overtime.store');

        // Leader Approval
        Route::get('/overtime/approval', 'approvalList')->name('overtime.approval');
        Route::post('/overtime/{id}/approve', 'approve')->name('overtime.approve');
        Route::post('/overtime/{id}/reject', 'reject')->name('overtime.reject');

        // Admin Report
        Route::get('/overtime/report', 'report')->name('overtime.report');
    });
});
