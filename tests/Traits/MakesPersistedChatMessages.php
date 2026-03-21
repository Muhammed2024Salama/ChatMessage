<?php

namespace Tests\Traits;

use App\Models\ChatMessage;
use App\Models\User;
use Tests\DTO\Chat\ChatMessageRecordDto;

trait MakesPersistedChatMessages
{
    protected function persistChatMessage(User $sender, User $receiver, array $overrides = []): ChatMessage
    {
        return ChatMessage::query()->create(
            ChatMessageRecordDto::between($sender, $receiver, $overrides)->toArray()
        );
    }
}
