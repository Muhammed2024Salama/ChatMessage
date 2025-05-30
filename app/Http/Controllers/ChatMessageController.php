<?php

namespace App\Http\Controllers;

use App\Http\Base\BaseController;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Services\ChatMessageService;
use Illuminate\Http\Request;

class ChatMessageController extends BaseController
{
    /**
     * @var ChatMessageService
     */
    protected ChatMessageService $chatMessageService;

    /**
     * @param ChatMessageService $chatMessageService
     */
    public function __construct(ChatMessageService $chatMessageService)
    {
        $this->chatMessageService = $chatMessageService;
    }

    /**
     * @param SendMessageRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(SendMessageRequest $request)
    {
        return $this->chatMessageService->sendMessage($request->validated());
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatHistory(int $senderId, int $receiverId)
    {
        return $this->chatMessageService->getChatHistory($senderId, $receiverId);
    }

    /**
     * @param int $senderId
     * @param int $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(int $senderId, int $receiverId)
    {
        return $this->chatMessageService->markAsRead($senderId, $receiverId);
    }

    /**
     * @param int $userId
     * @return \Illuminate\Http\JsonResponse
     */
    public function contacts(int $userId)
    {
        return $this->chatMessageService->getContacts($userId);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllChats()
    {
        return $this->chatMessageService->getAllChats();
    }
}
