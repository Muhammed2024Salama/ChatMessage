<?php

namespace Tests\Traits;

use Tests\DTO\Chat\SendMessageDto;

trait MakesSendMessagePayload
{
    protected function makeSendMessagePayload(array $overrides = []): array
    {
        return SendMessageDto::make($overrides)->toArray();
    }
}

