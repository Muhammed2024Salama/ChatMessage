<?php

namespace Tests\Helper;

use InvalidArgumentException;

final class StrictTestDtoOverrides
{
    public static function apply(object $dto, array $overrides): void
    {
        foreach ($overrides as $key => $value) {
            if (!property_exists($dto, $key)) {
                throw new InvalidArgumentException(sprintf('Invalid override property: %s', $key));
            }

            $dto->{$key} = $value;
        }
    }
}
