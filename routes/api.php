<?php

use App\Http\Controllers\ChatMessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/chat/send', [ChatMessageController::class, 'sendMessage']);
Route::get('/chat/history/{sender_id}/{receiver_id}', [ChatMessageController::class, 'getChatHistory']);
Route::post('/chat/mark-as-read/{messageId}', [ChatMessageController::class, 'markAsRead']);
