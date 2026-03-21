<?php

namespace Tests\DTO\Chat;

use App\Enums\MessageType;
use App\Models\User;
use Illuminate\Support\Carbon;
use Tests\Helper\StrictTestDtoOverrides;

final class ChatMessageRecordDto
{
    public function __construct(
        public int $sender_id,
        public int $receiver_id,
        public string $message_text = 'test',
        public string $message_type = MessageType::TEXT->value,
        public ?Carbon $sent_at = null,
    ) {
        $this->sent_at ??= now();
    }

    public static function between(User $sender, User $receiver, array $overrides = []): self
    {
        $dto = new self(
            sender_id: $sender->id,
            receiver_id: $receiver->id,
        );

        StrictTestDtoOverrides::apply($dto, $overrides);

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message_text' => $this->message_text,
            'message_type' => $this->message_type,
            'sent_at' => $this->sent_at,
        ];
    }
}
