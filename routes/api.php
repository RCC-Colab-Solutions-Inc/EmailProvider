<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmail;


Route::middleware(['check.api.key'])->group(function () {
    // All routes within this group will require the API key validation

    Route::post('/send-email', [SendEmail::class, 'sendEmail']);
    
});