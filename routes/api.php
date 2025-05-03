<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    // Public routes
    Route::post('register', 'register');
    Route::post('login', 'login');

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', 'userProfile');
        Route::get('logout', 'userLogout');

        // Nested Chat routes under auth
        Route::prefix('chat')->group(function () {
            Route::post('/send', [ChatMessageController::class, 'sendMessage']);
            Route::get('/history/{sender_id}', [ChatMessageController::class, 'getChatHistory']);
            Route::post('/mark-as-read/{senderId}', [ChatMessageController::class, 'markAsRead']);
            Route::get('/contacts/{sender_id}', [ChatMessageController::class, 'contacts']);
            Route::get('/all', [ChatMessageController::class, 'getAllChats']);
        });
    });
});

