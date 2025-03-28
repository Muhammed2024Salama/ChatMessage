<?php

namespace App\Services;

use App\Events\MessageSentEvent;
use App\Helper\ResponseHelper;
use App\Interface\ChatMessageInterface;

class ChatMessageService
{
    /**
     * @var ChatMessageInterface
     */
    protected $chatMessageRepository;

    /**
     * @param ChatMessageInterface $chatMessageRepository
     */
    public function __construct(ChatMessageInterface $chatMessageRepository)
    {
        $this->chatMessageRepository = $chatMessageRepository;
    }

    /**
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(array $data)
    {
        $message = $this->chatMessageRepository->sendMessage($data);
        broadcast(new MessageSentEvent($message))->toOthers();
        return ResponseHelper::success('success', 'Message sent successfully', $message);
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatHistory(int $senderId, int $receiverId)
    {
        $messages = $this->chatMessageRepository->getChatHistory($senderId, $receiverId);
        return ResponseHelper::success('success', 'Chat history retrieved', $messages);
    }

    /**
     * @param int $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(int $messageId)
    {
        $this->chatMessageRepository->markAsRead($messageId);
        return ResponseHelper::success('success', 'Message marked as read');
    }
}
