<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\ProjectScheduleController;



Route::get('/', function () {
    return view('auth.login');
});

Route::view('/login', 'auth.login')->name('login');
Route::post('/login', [AuthController::class, 'webLogin'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');
Route::view('/register', 'auth.register')->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');


Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

Route::get('/calendar/events', [ProjectScheduleController::class, 'events']);

Route::get('/events', [ProjectScheduleController::class, 'index'])
    ->name('project.events');

Route::get('/myproject', function () {
    return view('project.my_project'); // ตรวจสอบให้แน่ใจว่าไฟล์ชื่อ my_project.blade.php อยู่ในโฟลเดอร์ resources/views/project/
})->name('myproject');
