<?php

namespace App\Repository;

use App\Interface\ChatMessageInterface;
use Illuminate\Database\Eloquent\Collection;
use App\Models\ChatMessage;

class ChatMessageRepository implements ChatMessageInterface
{
    /**
     * @param array $data
     * @return ChatMessage
     */
    public function sendMessage(array $data): ChatMessage
    {
        return ChatMessage::create($data);
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return Collection
     */
    public function getChatHistory(int $senderId, int $receiverId): Collection
    {
        return ChatMessage::where(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->orderBy('sent_at', 'asc')->get();
    }

    /**
     * @param int $messageId
     * @return mixed
     */
    public function markAsRead(int $messageId)
    {
        return ChatMessage::where('message_id', $messageId)->update(['is_read' => true, 'read_at' => now()]);
    }
}
