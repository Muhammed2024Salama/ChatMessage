<?php

namespace Tests\DTO\Chat;

use App\Enums\MessageEntityType;
use App\Enums\MessageType;

final class SendMessageDto
{
    public function __construct(
        public int $sender_id,
        public int $receiver_id,
        public string $message_text,
        public string $message_type = MessageType::TEXT->value,
        public ?string $attachment_url = null,
        public string $entity_type = MessageEntityType::PROJECT->value,
        public ?int $entity_id = 1,
    ) {
    }

    public static function make(array $overrides = []): self
    {
        $dto = new self(
            sender_id: 1,
            receiver_id: 2,
            message_text: 'Hello from tests',
        );

        foreach ($overrides as $key => $value) {
            if (!property_exists($dto, $key)) {
                continue;
            }

            $dto->{$key} = $value;
        }

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'message_text' => $this->message_text,
            'message_type' => $this->message_type,
            'attachment_url' => $this->attachment_url,
            'entity_type' => $this->entity_type,
            'entity_id' => $this->entity_id,
        ];
    }
}

