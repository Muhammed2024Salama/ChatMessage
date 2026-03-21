<?php

namespace Tests\DTO\Events;

use App\Enums\MessageType;
use App\Models\ChatMessage;
use Illuminate\Support\Carbon;
use Tests\Helper\StrictTestDtoOverrides;

final class MessageSentEventDto
{
    public function __construct(
        public int $message_id = 77,
        public int $sender_id = 10,
        public int $receiver_id = 4,
        public string $message_text = 'Test message',
        public string $message_type = MessageType::TEXT->value,
        public ?string $attachment_url = null,
        public ?Carbon $created_at = null,
        public ?Carbon $updated_at = null,
    ) {
        $this->created_at ??= Carbon::parse('2026-03-19 10:00:00');
        $this->updated_at ??= Carbon::parse('2026-03-19 10:00:05');
    }

    public static function make(array $overrides = []): self
    {
        $dto = new self();

        StrictTestDtoOverrides::apply($dto, $overrides);

        return $dto;
    }

    public function toModel(): ChatMessage
    {
        $model = new ChatMessage();
        $model->setRawAttributes([
            'message_id' => $this->message_id,
            'id' => $this->message_id,
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message_text' => $this->message_text,
            'message_type' => $this->message_type,
            'attachment_url' => $this->attachment_url,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ], true);

        return $model;
    }
}

