<?php

namespace Tests\Unit\Events;

use App\Events\MessageSentEvent;
use Illuminate\Broadcasting\PrivateChannel;
use Tests\DTO\Events\MessageSentEventDto;
use Tests\TestCase;

class MessageSentEventTest extends TestCase
{
    public function test_broadcast_on_uses_ordered_participants_in_private_channel_name(): void
    {
        $message = MessageSentEventDto::make([
            'sender_id' => 30,
            'receiver_id' => 2,
        ])->toModel();

        $event = new MessageSentEvent($message);
        $channel = $event->broadcastOn();

        $this->assertInstanceOf(PrivateChannel::class, $channel);
        $this->assertSame('private-chat-2-30', $channel->name);
    }

    public function test_broadcast_as_returns_expected_event_name(): void
    {
        $message = MessageSentEventDto::make()->toModel();
        $event = new MessageSentEvent($message);

        $this->assertSame('message.sent', $event->broadcastAs());
    }

    public function test_broadcast_with_returns_expected_payload(): void
    {
        $message = MessageSentEventDto::make([
            'message_id' => 99,
            'sender_id' => 10,
            'receiver_id' => 4,
            'message_text' => 'Hello event',
            'message_type' => 'text',
            'attachment_url' => 'https://cdn.example.com/file.png',
        ])->toModel();

        $event = new MessageSentEvent($message);

        $this->assertSame([
            'id' => 99,
            'sender_id' => 10,
            'receiver_id' => 4,
            'message_text' => 'Hello event',
            'message_type' => 'text',
            'attachment_url' => 'https://cdn.example.com/file.png',
            'created_at' => $message->created_at->toISOString(),
            'updated_at' => $message->updated_at->toISOString(),
        ], $event->broadcastWith());
    }
}

