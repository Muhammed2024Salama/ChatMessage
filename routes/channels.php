<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-{senderId}-{receiverId}', function ($user, $senderId, $receiverId) {
    return (int)$user->user_id === (int)$senderId || (int)$user->user_id === (int)$receiverId;
});
