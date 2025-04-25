<?php

namespace App\Http\Controllers;

use App\Http\Base\BaseController;
use App\Services\ChatMessageService;
use Illuminate\Http\Request;

class ChatMessageController extends BaseController
{
    /**
     * @var ChatMessageService
     */
    protected $chatMessageService;

    /**
     * @param ChatMessageService $chatMessageService
     */
    public function __construct(ChatMessageService $chatMessageService)
    {
        $this->chatMessageService = $chatMessageService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $data = $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:users,id',
            'message_text' => 'nullable|string',
            'message_type' => 'required|string',
            'attachment_url' => 'nullable|string',
        ]);

        return $this->chatMessageService->sendMessage($data);
    }

    /**
     * @param $senderId
     * @param $receiverId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getChatHistory($senderId, $receiverId)
    {
        return $this->chatMessageService->getChatHistory($senderId, $receiverId);
    }

    /**
     * @param $messageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead($messageId)
    {
        return $this->chatMessageService->markAsRead($messageId);
    }
}
