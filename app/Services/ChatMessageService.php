<?php

namespace App\Services;

use App\Events\MessageSentEvent;
use App\Helper\ResponseHelper;
use App\Http\Resources\ChatMessageResource;
use App\Interface\ChatMessageInterface;

class ChatMessageService
{
    /**
     * @var ChatMessageInterface
     */
    protected ChatMessageInterface $chatMessageRepository;

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

        return ResponseHelper::success(
            'success',
            'Message sent successfully',
            new ChatMessageResource($message)
        );
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatHistory(int $senderId, int $receiverId)
    {
        $messages = $this->chatMessageRepository->getChatHistory($senderId, $receiverId);

        return ResponseHelper::success(
            'success',
            'Chat history retrieved',
            ChatMessageResource::collection($messages)
        );
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(int $senderId, int $receiverId)
    {
        $this->chatMessageRepository->markAsRead($senderId, $receiverId);
        return ResponseHelper::success('success', 'Messages marked as read');
    }

    /**
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts(int $userId)
    {
        $contacts = $this->chatMessageRepository->getContacts($userId);

        return ResponseHelper::success('success', 'Contacts retrieved', $contacts);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChats()
    {
        $messages = $this->chatMessageRepository->getAllChats();

        return ResponseHelper::success(
            'success',
            'All chat messages fetched successfully',
            ChatMessageResource::collection($messages)
        );
    }
}
