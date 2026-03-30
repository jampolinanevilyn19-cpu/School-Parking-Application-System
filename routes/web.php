<?php
// File: routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;

// Public routes
Route::get('/g', [ParkingController::class, 'showLogin'])->name('login');
Route::post('/login', [ParkingController::class, 'login'])->name('login.submit');
Route::post('/register', [ParkingController::class, 'register'])->name('register.submit');
Route::get('/logout', [ParkingController::class, 'logout'])->name('logout');

// Protected routes (with session check)
Route::middleware(['check.session'])->group(function () {
    // Common routes
    Route::get('/dashboard', [ParkingController::class, 'dashboard'])->name('dashboard');
    Route::get('/system-info', [ParkingController::class, 'systemInfo'])->name('system.info');
    
    // Student routes
    Route::get('/apply', [ParkingController::class, 'showApplyForm'])->name('apply.form');
    Route::post('/apply', [ParkingController::class, 'submitApplication'])->name('apply.submit');
    Route::get('/my-applications', [ParkingController::class, 'myApplications'])->name('my.applications');
    
    // Admin routes
    Route::get('/admin/applications', [ParkingController::class, 'adminApplications'])->name('admin.applications');
    Route::post('/admin/approve/{id}', [ParkingController::class, 'approveApplication'])->name('admin.approve');
    Route::delete('/admin/delete/{id}', [ParkingController::class, 'deleteApplication'])->name('admin.delete');
    Route::get('/admin/transactions', [ParkingController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/parking-spots', [ParkingController::class, 'parkingSpots'])->name('admin.parking.spots');
    Route::get('/admin/reports', [ParkingController::class, 'reports'])->name('admin.reports');
});