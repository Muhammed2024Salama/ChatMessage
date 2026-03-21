<?php

namespace Tests\Unit\Helper;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Tests\Helper\StrictTestDtoOverrides;

class StrictTestDtoOverridesTest extends TestCase
{
    public function test_throws_on_unknown_override_key(): void
    {
        $dto = new class {
            public string $known = 'a';
        };

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid override property: typo');

        StrictTestDtoOverrides::apply($dto, ['typo' => 'x']);
    }
}
