<?php

use Illuminate\Support\Facades\Route;

Route::get('device/login', function () {
    return view('device-login');
});
Route::get('device/auth/{google}', [\App\Http\Controllers\API\Device\SocialLoginController::class, 'redirectLogin'])
    ->name('google.login');
Route::get('device/auth/{facebook}', [\App\Http\Controllers\API\Device\SocialLoginController::class, 'redirectLogin'])
    ->name('facebook.login');

Route::get('/auth/google/callback', function () {
    return socialLogin('google');
})->name('google.login.callback');
Route::get('/auth/facebook/callback', function () {
    return socialLogin('facebook');
})->name('facebook.login.callback');
