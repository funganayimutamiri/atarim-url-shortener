<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Route for handling short URL redirects
Route::get('/{hash}', [UrlController::class, 'redirect'])
    ->where('hash', '[A-Za-z0-9]{6}');
