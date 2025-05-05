<?php

namespace App\Repository;

use App\Interface\ChatMessageInterface;
use App\Models\User;
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

    /**
     * @param int $userId
     * @return mixed
     */
    public function getContacts(int $userId)
    {
        $contactIds = ChatMessage::where('sender_id', $userId)
            ->pluck('receiver_id')
            ->merge(
                ChatMessage::where('receiver_id', $userId)->pluck('sender_id')
            )
            ->unique()
            ->toArray();

        return User::whereIn('id', $contactIds)
            ->with(['lastMessage' => function ($query) use ($userId) {
                $query->where(function ($q) use ($userId) {
                    $q->where('chat_messages.sender_id', $userId)
                        ->orWhere('chat_messages.receiver_id', $userId);
                })
                    ->latest('chat_messages.sent_at');
            }])
            ->get();

    }

    /**
     * Get all chat messages.
     *
     * @return mixed
     */
    public function getAllChats()
    {
        return ChatMessage::with(['sender', 'receiver'])
            ->orderBy('sent_at', 'desc')
            ->get();
    }
}
