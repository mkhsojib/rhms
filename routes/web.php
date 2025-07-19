<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\SettingController as SuperAdminSettingController;
use App\Http\Controllers\SuperAdmin\AppointmentController as SuperAdminAppointmentController;
use App\Http\Controllers\SuperAdmin\TreatmentController as SuperAdminTreatmentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\TreatmentController as AdminTreatmentController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Patient Profile Management Routes
Route::middleware(['auth', 'checkRole:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::post('appointments/get-session-types', [PatientAppointmentController::class, 'getSessionTypes'])->name('appointments.getSessionTypes');
    Route::post('appointments/get-available-dates', [PatientAppointmentController::class, 'getAvailableDates'])->name('appointments.getAvailableDates');
    Route::post('appointments/get-available-times', [PatientAppointmentController::class, 'getAvailableTimeSlots'])->name('appointments.getAvailableTimes');
    
    // Custom resource routes without edit and update
    Route::get('appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('appointments/create', [PatientAppointmentController::class, 'create'])->name('appointments.create');
    Route::post('appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');
    Route::get('appointments/{appointment}', [PatientAppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('appointments/{appointment}', [PatientAppointmentController::class, 'destroy'])->name('appointments.destroy');
    
    Route::get('/profile', [PatientProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [PatientProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [PatientProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [PatientProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Notification routes
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
    Route::get('notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
    Route::post('notifications/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::post('notifications/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-unread');
    Route::delete('notifications/delete-read', [NotificationController::class, 'deleteRead'])->name('notifications.delete-read');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Admin & Super Admin Profile Management Routes
Route::middleware(['auth', 'checkRole:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
});

// Super Admin Routes
Route::middleware(['auth', 'checkRole:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('users', SuperAdminUserController::class);
    Route::resource('settings', SuperAdminSettingController::class);
    Route::resource('appointments', SuperAdminAppointmentController::class);
    Route::resource('treatments', SuperAdminTreatmentController::class);
    Route::resource('blogs', App\Http\Controllers\SuperAdmin\BlogController::class); // <-- Add this line
    Route::resource('categories', App\Http\Controllers\SuperAdmin\CategoryController::class);
    
    // Appointment action routes
    Route::patch('appointments/{appointment}/approve', [SuperAdminAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('appointments/{appointment}/reject', [SuperAdminAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::patch('appointments/{appointment}/complete', [SuperAdminAppointmentController::class, 'complete'])->name('appointments.complete');
    
    // Settings group routes
    Route::get('settings/general', [SuperAdminSettingController::class, 'general'])->name('settings.general');
    Route::post('settings/general', [SuperAdminSettingController::class, 'updateGeneral'])->name('settings.general.update');
    Route::get('settings/appearance', [SuperAdminSettingController::class, 'appearance'])->name('settings.appearance');
    Route::post('settings/appearance', [SuperAdminSettingController::class, 'updateAppearance'])->name('settings.appearance.update');
    Route::get('settings/system', [SuperAdminSettingController::class, 'system'])->name('settings.system');
    Route::post('settings/system', [SuperAdminSettingController::class, 'updateSystem'])->name('settings.system.update');
    Route::get('settings/business', [SuperAdminSettingController::class, 'business'])->name('settings.business');
    Route::post('settings/business', [SuperAdminSettingController::class, 'updateBusiness'])->name('settings.business.update');
});

// SuperAdmin Appointment AJAX endpoints
Route::prefix('superadmin/appointments')->name('superadmin.appointments.')->group(function () {
    Route::post('get-session-types', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getSessionTypes'])->name('getSessionTypes');
    Route::post('get-available-dates', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getAvailableDates'])->name('getAvailableDates');
    Route::post('get-available-times', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getAvailableTimes'])->name('getAvailableTimes');
});

// Admin (Raqi/Hijama Practitioner) Routes
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('appointments', AdminAppointmentController::class);
    Route::patch('appointments/{appointment}/approve', [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('appointments/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::patch('appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
    
    Route::resource('treatments', AdminTreatmentController::class);
    
    // Raqi Availability Routes
    Route::resource('availability', 'App\Http\Controllers\Admin\RaqiAvailabilityController');
    Route::get('availability/get-available-time-slots', ['App\Http\Controllers\Admin\RaqiAvailabilityController', 'getAvailableTimeSlots'])->name('availability.getAvailableTimeSlots');
});

Route::post('/patient/appointments/get-available-time-slots', [App\Http\Controllers\Patient\AppointmentController::class, 'getAvailableTimeSlots'])->name('patient.appointments.getAvailableTimeSlots');

// Public Blog Routes
Route::get('blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('blogs/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');


