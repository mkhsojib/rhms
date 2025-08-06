<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\SettingController as SuperAdminSettingController;
use App\Http\Controllers\SuperAdmin\AppointmentController as SuperAdminAppointmentController;
use App\Http\Controllers\SuperAdmin\TreatmentController as SuperAdminTreatmentController;
use App\Http\Controllers\SuperAdmin\RaqiAvailabilityController as SuperAdminRaqiAvailabilityController;
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

    Route::get('appointments/{appointment}/questions', [\App\Http\Controllers\Patient\AppointmentQuestionController::class, 'showForm'])->name('appointments.questions.form');
    Route::post('appointments/{appointment}/questions', [\App\Http\Controllers\Patient\AppointmentQuestionController::class, 'submitAnswers'])->name('appointments.questions.submit');
    Route::get('appointments/{appointment}/questions/download', [\App\Http\Controllers\Patient\AppointmentQuestionController::class, 'downloadAnswers'])->name('appointments.questions.download');
    Route::get('appointments/{appointment}/invoice/download', [PatientAppointmentController::class, 'downloadInvoice'])->name('appointments.invoice.download');
});

// Admin & Super Admin Profile Management Routes
Route::middleware(['auth', 'checkRole:admin,super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('appointments/{appointment}/questions/edit', [\App\Http\Controllers\Admin\AppointmentQuestionController::class, 'editForm'])->name('appointments.questions.edit');
    Route::post('appointments/{appointment}/questions/update', [\App\Http\Controllers\Admin\AppointmentQuestionController::class, 'updateAnswers'])->name('appointments.questions.update');
    Route::get('appointments/{appointment}/questions/download', [\App\Http\Controllers\Admin\AppointmentQuestionController::class, 'downloadAnswers'])->name('appointments.questions.download');
});

// Super Admin Routes
Route::middleware(['auth', 'checkRole:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    // Route model binding for raqi availability
    Route::bind('availability', function ($value) {
        return \App\Models\RaqiMonthlyAvailability::findOrFail($value);
    });
    Route::resource('users', SuperAdminUserController::class);
    Route::resource('settings', SuperAdminSettingController::class);
    Route::resource('appointments', SuperAdminAppointmentController::class);
    Route::resource('treatments', SuperAdminTreatmentController::class);
    Route::resource('medicines', App\Http\Controllers\SuperAdmin\MedicineController::class);
    Route::resource('symptoms', App\Http\Controllers\SuperAdmin\SymptomController::class);
    Route::resource('raqi-availability', SuperAdminRaqiAvailabilityController::class)->parameters(['raqi-availability' => 'availability']);
    Route::get('raqi-availability/practitioner/{practitioner}', [SuperAdminRaqiAvailabilityController::class, 'byPractitioner'])->name('raqi-availability.by-practitioner');
    Route::resource('blogs', App\Http\Controllers\SuperAdmin\BlogController::class); // <-- Add this line
    Route::resource('categories', App\Http\Controllers\SuperAdmin\CategoryController::class);
    Route::resource('contact-information', App\Http\Controllers\SuperAdmin\ContactInformationController::class);
    Route::resource('contact-form-submissions', App\Http\Controllers\SuperAdmin\ContactFormSubmissionController::class);
    Route::patch('contact-form-submissions/{contactFormSubmission}/mark-read', [App\Http\Controllers\SuperAdmin\ContactFormSubmissionController::class, 'markAsRead'])->name('contact-form-submissions.mark-read');
    Route::patch('contact-form-submissions/{contactFormSubmission}/mark-replied', [App\Http\Controllers\SuperAdmin\ContactFormSubmissionController::class, 'markAsReplied'])->name('contact-form-submissions.mark-replied');
    Route::get('contact-form-submissions/filter', [App\Http\Controllers\SuperAdmin\ContactFormSubmissionController::class, 'filter'])->name('contact-form-submissions.filter');
    
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
    Route::get('transactions/create', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'index'])->name('transactions.index');
    Route::post('transactions/{id}/void', [App\Http\Controllers\SuperAdmin\TransactionController::class, 'void'])->name('transactions.void');
    Route::resource('invoices', App\Http\Controllers\SuperAdmin\InvoiceController::class)->only(['index', 'show']);
    Route::get('invoices/{invoice}/print', [App\Http\Controllers\SuperAdmin\InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{invoice}/download', [App\Http\Controllers\SuperAdmin\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('invoices/{invoice}/pay', [App\Http\Controllers\SuperAdmin\InvoiceController::class, 'pay'])->name('invoices.pay');
    Route::post('invoices/{invoice}/pay', [App\Http\Controllers\SuperAdmin\InvoiceController::class, 'storePayment'])->name('invoices.storePayment');
    Route::get('invoices/{invoice}/pay-page', [App\Http\Controllers\SuperAdmin\InvoiceController::class, 'payPage'])->name('invoices.payPage');
    
    // Payments
    Route::get('payments', [App\Http\Controllers\SuperAdmin\PaymentController::class, 'index'])->name('payments.index');
    Route::get('payments/{payment}', [App\Http\Controllers\SuperAdmin\PaymentController::class, 'show'])->name('payments.show');
    Route::resource('questions', \App\Http\Controllers\SuperAdmin\QuestionController::class);
    Route::get('appointments/{appointment}/questions/edit', [\App\Http\Controllers\SuperAdmin\AppointmentQuestionController::class, 'editForm'])->name('appointments.questions.edit');
    Route::post('appointments/{appointment}/questions/update', [\App\Http\Controllers\SuperAdmin\AppointmentQuestionController::class, 'updateAnswers'])->name('appointments.questions.update');
    Route::get('appointments/{appointment}/questions/download', [\App\Http\Controllers\SuperAdmin\AppointmentQuestionController::class, 'downloadAnswers'])->name('appointments.questions.download');
    
    // AJAX routes for medicines and symptoms
    Route::get('medicines/ajax', [App\Http\Controllers\SuperAdmin\MedicineController::class, 'getMedicines'])->name('medicines.ajax');
    Route::get('symptoms/ajax', [App\Http\Controllers\SuperAdmin\SymptomController::class, 'getSymptoms'])->name('symptoms.ajax');
    Route::post('treatments/get-symptoms-by-appointment', [SuperAdminTreatmentController::class, 'getSymptomsByAppointmentType'])->name('treatments.getSymptomsByAppointment');
    Route::post('treatments/get-patient-answers', [SuperAdminTreatmentController::class, 'getPatientAnswers'])->name('treatments.getPatientAnswers');
    Route::get('treatments/{treatment}/prescription', [SuperAdminTreatmentController::class, 'prescription'])->name('treatments.prescription');
});

// SuperAdmin Appointment AJAX endpoints
Route::prefix('superadmin/appointments')->name('superadmin.appointments.')->group(function () {
    Route::post('get-session-types', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getSessionTypes'])->name('getSessionTypes');
    Route::post('get-available-dates', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getAvailableDates'])->name('getAvailableDates');
    Route::post('get-available-times', [\App\Http\Controllers\SuperAdmin\AppointmentController::class, 'getAvailableTimes'])->name('getAvailableTimes');
});

// SuperAdmin Bank Accounts
Route::middleware(['auth', 'can:super_admin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('bank-accounts', App\Http\Controllers\SuperAdmin\BankAccountController::class);
    Route::get('cash-flows', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'index'])->name('cash-flows.index');
    Route::get('cash-flows/cash-in/create', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'createCashIn'])->name('cash-flows.createCashIn');
    Route::post('cash-flows/cash-in', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'storeCashIn'])->name('cash-flows.storeCashIn');
    Route::get('cash-flows/cash-out/create', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'createCashOut'])->name('cash-flows.createCashOut');
    Route::post('cash-flows/cash-out', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'storeCashOut'])->name('cash-flows.storeCashOut');
    Route::get('cash-flows/{cashFlow}/edit', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'edit'])->name('cash-flows.edit');
    Route::put('cash-flows/{cashFlow}', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'update'])->name('cash-flows.update');
    Route::delete('cash-flows/{cashFlow}', [App\Http\Controllers\SuperAdmin\CashFlowController::class, 'destroy'])->name('cash-flows.destroy');
});

// Admin (Raqi/Hijama Practitioner) Routes
Route::middleware(['auth', 'checkRole:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('appointments', AdminAppointmentController::class);
    Route::post('appointments/get-session-types', [AdminAppointmentController::class, 'getSessionTypes'])->name('appointments.getSessionTypes');
    Route::patch('appointments/{appointment}/approve', [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
    Route::patch('appointments/{appointment}/reject', [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
    Route::patch('appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
    
    Route::resource('treatments', AdminTreatmentController::class);
    Route::post('treatments/get-patient-answers', [AdminTreatmentController::class, 'getPatientAnswers'])->name('treatments.getPatientAnswers');
    
    // Raqi Availability Routes
    Route::resource('availability', 'App\Http\Controllers\Admin\RaqiAvailabilityController');
    Route::get('availability/get-available-time-slots', ['App\Http\Controllers\Admin\RaqiAvailabilityController', 'getAvailableTimeSlots'])->name('availability.getAvailableTimeSlots');
    Route::resource('invoices', App\Http\Controllers\Admin\InvoiceController::class)->only(['index', 'show']);
    Route::get('invoices/{invoice}/print', [App\Http\Controllers\Admin\InvoiceController::class, 'print'])->name('invoices.print');
    Route::get('invoices/{invoice}/download', [App\Http\Controllers\Admin\InvoiceController::class, 'download'])->name('invoices.download');
    Route::get('invoices/{invoice}/pay-page', [App\Http\Controllers\Admin\InvoiceController::class, 'payPage'])->name('invoices.payPage');
    Route::post('invoices/{invoice}/pay', [App\Http\Controllers\Admin\InvoiceController::class, 'storePayment'])->name('invoices.storePayment');
});

Route::post('/patient/appointments/get-available-time-slots', [App\Http\Controllers\Patient\AppointmentController::class, 'getAvailableTimeSlots'])->name('patient.appointments.getAvailableTimeSlots');

// Public Blog Routes
Route::get('blogs', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('blogs/{blog}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');

// Contact Form Routes
Route::post('/contact-form/submit', [App\Http\Controllers\ContactFormController::class, 'submit'])->name('contact-form.submit');


