<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\FaceController;


Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Dashboard semua user
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin routes (role = 1)
    Route::middleware('role:1')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/absensi', [AdminAbsensiController::class, 'index'])->name('absensi.index');
        Route::get('/absensi/export/pdf', [AdminAbsensiController::class, 'exportPdf'])->name('absensi.export.pdf');

        Route::get('/leave-requests', [AdminLeaveRequestController::class, 'index'])->name('leave.index');
        Route::post('/leave-requests/{leaveRequest}/status', [AdminLeaveRequestController::class, 'updateStatus'])->name('leave.update');

        Route::get('locations', [LocationController::class, 'index'])->name('locations.index');
        Route::get('locations/create', [LocationController::class, 'create'])->name('locations.create');
        Route::post('locations', [LocationController::class, 'store'])->name('locations.store');
        Route::post('locations/{id}/activate', [LocationController::class, 'activate'])->name('locations.activate');
        Route::post('locations/{id}/deactivate', [LocationController::class, 'deactivate'])->name('locations.deactivate');
        Route::get('locations/{location}/edit', [LocationController::class, 'edit'])->name('locations.edit');
        Route::put('locations/{location}', [LocationController::class, 'update'])->name('locations.update');
        Route::delete('locations/{location}', [LocationController::class, 'destroy'])->name('locations.destroy');
    });

    // Karyawan & PKL routes (role = 2 atau 3)
    Route::middleware('role:2,3')->group(function () {
        // Absensi
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::post('/absensi/checkin', [AbsensiController::class, 'checkin'])->name('absensi.checkin');
        Route::post('/absensi/checkout', [AbsensiController::class, 'checkout'])->name('absensi.checkout');

        // Face ID (dalam konteks absensi)
        Route::get('/absensi/face-register', [AbsensiController::class, 'faceRegister'])->name('absensi.face.register');
        Route::post('/absensi/face-register', [AbsensiController::class, 'faceRegisterStore'])->name('absensi.face.register.store');
        Route::get('/absensi/face-register', [AbsensiController::class, 'faceRegister'])->name('absensi.face.register');
        Route::post('/absensi/face-register', [AbsensiController::class, 'faceRegisterStore'])->name('absensi.face.register.store');

        Route::get('/absensi/face-validate', [FaceController::class, 'validateFace'])->name('absensi.face.validate');
        Route::post('/absensi/face-match', [FaceController::class, 'match'])->name('absensi.face.match');


        // Leave Requests
        Route::get('/leave_requests', [LeaveRequestController::class, 'index'])->name('leave_requests.index');
        Route::get('/leave_requests/create', [LeaveRequestController::class, 'create'])->name('leave_requests.create');
        Route::post('/leave_requests', [LeaveRequestController::class, 'store'])->name('leave_requests.store');
    });


});

require __DIR__ . '/auth.php';
