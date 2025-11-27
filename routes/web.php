<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
<<<<<<< HEAD

// Routes d'authentification (si vous utilisez Laravel Breeze/Jetstream)
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
=======
>>>>>>> c67af85b04c91d8a379978a1ba61283e1d36487f
