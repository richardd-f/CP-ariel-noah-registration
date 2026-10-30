<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [RegistrationController::class, 'index'])->name('home');
Route::post('/register', [RegistrationController::class, 'store'])->name('register.store');
Route::get('/registration/{ticketId}/confirm', [RegistrationController::class, 'confirm'])
    ->middleware('signed')
    ->name('registration.confirm');
Route::get('/ticket/{ticketId}', [RegistrationController::class, 'show'])->name('ticket.show');
Route::get('/ticket/{ticketId}/download', [RegistrationController::class, 'download'])->name('ticket.download');
