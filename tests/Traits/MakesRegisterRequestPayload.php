<?php

namespace Tests\Traits;

use Tests\DTO\Auth\RegisterRequestPayloadDto;

trait MakesRegisterRequestPayload
{
    protected function makeRegisterPayload(array $overrides = []): array
    {
        return RegisterRequestPayloadDto::make($overrides)->toArray();
    }
}
