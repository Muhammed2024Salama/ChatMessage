<?php

namespace Tests\Feature\Middleware;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\MakesRoleUsers;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;
    use MakesRoleUsers;

    public function test_admin_user_can_access_admin_chat_route(): void
    {
        $admin = $this->makeAdminUser();
        $this->authenticateViaSanctum($admin);

        $response = $this->getJson('/api/chat/all');

        $response->assertOk();
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('message', 'All chat messages fetched successfully');
    }

    public function test_authenticated_non_admin_user_gets_forbidden_response(): void
    {
        $user = $this->makeRegularUser();
        $this->authenticateViaSanctum($user);

        $response = $this->getJson('/api/chat/all');

        $response->assertForbidden();
        $response->assertJson([
            'status' => 'error',
            'message' => 'Access denied. Admins only.',
        ]);
    }

    public function test_unauthenticated_user_gets_unauthorized_before_admin_middleware(): void
    {
        $response = $this->getJson('/api/chat/all');

        $response->assertUnauthorized();
    }
}

