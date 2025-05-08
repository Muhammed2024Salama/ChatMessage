<?php

namespace App\Interface;

use App\Models\ChatMessage;

interface ChatMessageInterface
{
    /**
     * @param array $data
     * @return ChatMessage
     */
    public function sendMessage(array $data): ChatMessage;

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return mixed
     */
    public function getChatHistory(int $senderId, int $receiverId);

    /**
     * @param int $senderId
     * @return mixed
     */
    public function markAsRead(int $senderId);

    /**
     * @param int $userId
     * @return mixed
     */
    public function getContacts(int $userId);

    /**
     * Get all chat messages.
     *
     * @return mixed
     */
    public function getAllChats();
}
