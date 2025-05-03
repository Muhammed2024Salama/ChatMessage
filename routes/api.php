<?php

use App\Http\Controllers\ChatMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('chat')->group(function () {
    Route::post('/send', [ChatMessageController::class, 'sendMessage']);
    Route::get('/history/{sender_id}', [ChatMessageController::class, 'getChatHistory']);
    Route::post('/mark-as-read/{senderId}', [ChatMessageController::class, 'markAsRead']);
    Route::get('/contacts/{sender_id}', [ChatMessageController::class, 'contacts']);
    Route::get('/all', [ChatMessageController::class, 'getAllChats']);
});

