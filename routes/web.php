<?php

use App\Http\Controllers\AuthControllerAN;
use App\Http\Controllers\CategoryControllerAN;
use App\Http\Controllers\DashboardControllerAN;
use App\Http\Controllers\ProfileControllerAN;
use App\Http\Controllers\ReminderControllerAN;
use App\Http\Controllers\TaskControllerAKL;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthControllerAN::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthControllerAN::class, 'login']);
    Route::get('/register', [AuthControllerAN::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthControllerAN::class, 'register']);
});

Route::post('/logout', [AuthControllerAN::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'log.an'])->group(function () {
    Route::get('/dashboard', DashboardControllerAN::class)->name('dashboard');
    Route::get('/profile', [ProfileControllerAN::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileControllerAN::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileControllerAN::class, 'updatePassword'])->name('profile.password.update');
    Route::put('/settings/notifications', [ProfileControllerAN::class, 'updateSettings'])->name('settings.notifications');
    Route::get('/notifications/settings', [ProfileControllerAN::class, 'showNotificationSettings'])->name('notifications.settings');
    Route::get('/tasks/{task}/confirmation', [TaskControllerAKL::class, 'confirmation'])->name('tasks.confirmation');
    Route::get('/tasks/assigned', [TaskControllerAKL::class, 'assigned'])->name('tasks.assigned');
    Route::get('/admin/reminders', [ReminderControllerAN::class, 'show'])
        ->middleware('role.an:admin')
        ->name('reminders.form');

    Route::post('/reminders/deadlines', [ReminderControllerAN::class, 'send'])
        ->middleware('role.an:admin')
        ->name('reminders.deadlines');
    Route::resource('tasks', TaskControllerAKL::class);
    Route::resource('categories', CategoryControllerAN::class)->only(['index', 'store', 'destroy'])
        ->middleware('role.an:admin,team_member');
    Route::resource('users', \App\Http\Controllers\UserControllerAN::class)->only(['index', 'show', 'edit', 'update', 'destroy'])
        ->middleware('role.an:admin');
});
