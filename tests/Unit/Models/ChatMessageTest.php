<?php

namespace Tests\Unit\Models;

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class ChatMessageTest extends TestCase
{
    public function test_table_and_primary_key_configuration(): void
    {
        $model = new ChatMessage;

        $this->assertSame('chat_messages', $model->getTable());
        $this->assertSame('message_id', $model->getKeyName());
    }

    public function test_fillable_attributes(): void
    {
        $expected = [
            'sender_id',
            'receiver_id',
            'message_text',
            'message_type',
            'attachment_url',
            'is_read',
            'sent_at',
            'read_at',
        ];

        $model = new ChatMessage;

        $this->assertEqualsCanonicalizing($expected, $model->getFillable());
    }

    public function test_sender_belongs_to_user(): void
    {
        $model = new ChatMessage;
        $relation = $model->sender();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertSame('sender_id', $relation->getForeignKeyName());
    }

    public function test_receiver_belongs_to_user(): void
    {
        $model = new ChatMessage;
        $relation = $model->receiver();

        $this->assertInstanceOf(BelongsTo::class, $relation);
        $this->assertInstanceOf(User::class, $relation->getRelated());
        $this->assertSame('receiver_id', $relation->getForeignKeyName());
    }
}
