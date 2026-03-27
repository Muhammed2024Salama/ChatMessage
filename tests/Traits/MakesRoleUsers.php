<?php

namespace Tests\Traits;

use App\Enums\UserRole;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

trait MakesRoleUsers
{
    protected function makeAdminUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'role' => UserRole::ADMIN->value,
        ], $overrides));
    }

    protected function makeRegularUser(array $overrides = []): User
    {
        return User::factory()->create(array_merge([
            'role' => UserRole::USER->value,
        ], $overrides));
    }

    protected function authenticateViaSanctum(User $user): void
    {
        Sanctum::actingAs($user);
    }
}

