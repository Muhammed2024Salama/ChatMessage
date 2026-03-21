<?php

namespace Tests\Unit\Models;

use App\Enums\UserRole;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_fillable_attributes(): void
    {
        $expected = ['name', 'email', 'password'];

        $user = new User;

        $this->assertEqualsCanonicalizing($expected, $user->getFillable());
    }

    public function test_hidden_attributes(): void
    {
        $expected = ['password', 'remember_token'];

        $user = new User;

        $this->assertEqualsCanonicalizing($expected, $user->getHidden());
    }

    public function test_casts_include_expected_types(): void
    {
        $user = new User;
        $casts = $user->getCasts();

        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertSame('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('password', $casts);
        $this->assertSame('hashed', $casts['password']);
        $this->assertArrayHasKey('role', $casts);
        $this->assertSame(UserRole::class, $casts['role']);
    }

    public function test_chat_messages_sent_has_many_relation(): void
    {
        $user = new User;
        $relation = $user->chatMessagesSent();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(ChatMessage::class, $relation->getRelated());
        $this->assertSame('sender_id', $relation->getForeignKeyName());
    }

    public function test_chat_messages_received_has_many_relation(): void
    {
        $user = new User;
        $relation = $user->chatMessagesReceived();

        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(ChatMessage::class, $relation->getRelated());
        $this->assertSame('receiver_id', $relation->getForeignKeyName());
    }

    public function test_last_message_relation_structure(): void
    {
        $user = new User;
        $relation = $user->lastMessage();

        $this->assertInstanceOf(HasOne::class, $relation);
        $this->assertInstanceOf(ChatMessage::class, $relation->getRelated());
        $this->assertSame('sender_id', $relation->getForeignKeyName());
        $this->assertSame('id', $relation->getLocalKeyName());
    }
}
