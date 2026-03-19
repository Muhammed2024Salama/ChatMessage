<?php

namespace Tests\Unit\Enums;

use App\Enums\UserRole;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_values_returns_all_defined_user_roles(): void
    {
        $expected = ['admin', 'user'];

        $values = array_map(static fn (UserRole $role): string => $role->value, UserRole::cases());

        $this->assertSame($expected, $values);
        $this->assertCount(2, UserRole::cases());
    }
}

