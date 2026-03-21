<?php

namespace Tests\Traits;

use App\Models\User;

trait MakesChatParticipantUsers
{
    protected function makeSenderAndReceiverUsers(): array
    {
        return [
            'sender' => User::factory()->create(),
            'receiver' => User::factory()->create(),
        ];
    }
}
