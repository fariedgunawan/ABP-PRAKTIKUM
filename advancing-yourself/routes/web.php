<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MailController;
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
    return view('welcome');
});

Route::get('/contact', [ContactController::class, 'create']);
Route::post('/contact', [ContactController::class, 'store']);
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/upload', [FileController::class, 'form']);
Route::post('/upload', [FileController::class, 'upload']);
Route::post('/contact/send-mail', [ContactController::class, 'sendMail'])->name('contact.send.mail');

// Menampilkan form kirim email
Route::get('/send-mail', [MailController::class, 'form'])->name('send.mail.form');

// Mengirim email via POST
Route::post('/send-mail', [MailController::class, 'send'])->name('send.mail');
