<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MakesChatParticipantUsers;
use Tests\Traits\MakesPersistedChatMessages;

class UserLastMessageRelationTest extends TestCase
{
    use RefreshDatabase;
    use MakesChatParticipantUsers;
    use MakesPersistedChatMessages;

    public function test_last_message_returns_latest_chat_message_by_sent_at(): void
    {
        ['sender' => $sender, 'receiver' => $receiver] = $this->makeSenderAndReceiverUsers();

        $this->persistChatMessage($sender, $receiver, [
            'message_text' => 'older',
            'sent_at' => now()->subHour(),
        ]);

        $latest = $this->persistChatMessage($sender, $receiver, [
            'message_text' => 'newer',
            'sent_at' => now(),
        ]);

        $lastMessage = $sender->fresh()->lastMessage;

        $this->assertNotNull($lastMessage);
        $this->assertTrue($latest->is($lastMessage));
    }
}
