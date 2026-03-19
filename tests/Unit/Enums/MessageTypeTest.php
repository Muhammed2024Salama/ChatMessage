<?php

namespace Tests\Unit\Enums;

use App\Enums\MessageType;
use PHPUnit\Framework\TestCase;

class MessageTypeTest extends TestCase
{
    public function test_values_returns_all_defined_message_types(): void
    {
        $expected = ['text', 'image', 'video', 'document', 'audio'];

        $this->assertSame($expected, MessageType::values());
        $this->assertCount(5, MessageType::values());
        $this->assertSame(count(MessageType::values()), count(array_unique(MessageType::values())));
    }
}

