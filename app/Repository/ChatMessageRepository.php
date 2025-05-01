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
        $data['sent_at'] = $data['sent_at'] ?? now();
        return ChatMessage::create($data);
    }

    /**
     * @param int $senderId
     * @return Collection
     */
    public function getChatHistory(int $senderId): Collection
    {
        return ChatMessage::where('sender_id', $senderId)
            ->orWhere('receiver_id', $senderId)
            ->orderBy('sent_at', 'asc')
            ->get();
    }

    /**
     * @param int $senderId
     * @return mixed
     */
    public function markAsRead(int $senderId)
    {
        return ChatMessage::where('sender_id', $senderId)->update(['is_read' => true, 'read_at' => now()]);
    }
}
