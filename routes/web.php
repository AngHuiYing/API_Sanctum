<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

//Route::get('/', function () {
    //return view('welcome');
//});

Route::get('/register',[ViewController::class, 'register'])->name('RegisterForm');
Route::get('/',[ViewController::class, 'index'])->name('LoginForm');
Route::get('/dashboard',[ViewController::class, 'dashboard'])->name('Dashboard');
Route::get('/addProduct',[ViewController::class, 'addProduct'])->name('addProduct');
Route::get('/viewProduct',[ViewController::class, 'viewProduct'])->name('viewProduct');