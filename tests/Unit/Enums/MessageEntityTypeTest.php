<?php

namespace Tests\Unit\Enums;

use App\Enums\MessageEntityType;
use PHPUnit\Framework\TestCase;

class MessageEntityTypeTest extends TestCase
{
    public function test_values_returns_all_defined_entity_types(): void
    {
        $expected = ['project', 'property', 'developer'];

        $this->assertSame($expected, MessageEntityType::values());
        $this->assertCount(3, MessageEntityType::values());
        $this->assertSame(count(MessageEntityType::values()), count(array_unique(MessageEntityType::values())));
    }
}

