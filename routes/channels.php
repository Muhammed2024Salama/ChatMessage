<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-{senderId}-{receiverId}', function ($user, $senderId, $receiverId) {
    return (int)$user->id === (int)$senderId || (int)$user->id === (int)$receiverId;
});
