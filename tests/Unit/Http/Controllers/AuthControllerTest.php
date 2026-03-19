<?php

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\AuthController;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Mockery;
use PHPUnit\Framework\TestCase;

class AuthControllerTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    public function test_register_forwards_request_to_auth_service(): void
    {
        $authService = Mockery::mock(AuthService::class);
        $controller = new AuthController($authService);

        $request = Mockery::mock(RegisterRequest::class);

        $expectedResponse = (object) ['ok' => true];

        $authService->shouldReceive('register')->once()->with($request)->andReturn($expectedResponse);

        $response = $controller->register($request);

        $this->assertSame($expectedResponse, $response);
    }

    public function test_login_forwards_request_to_auth_service(): void
    {
        $authService = Mockery::mock(AuthService::class);
        $controller = new AuthController($authService);

        $request = Mockery::mock(LoginRequest::class);

        $expectedResponse = (object) ['ok' => true];

        $authService->shouldReceive('login')->once()->with($request)->andReturn($expectedResponse);

        $response = $controller->login($request);

        $this->assertSame($expectedResponse, $response);
    }

    public function test_user_profile_forwards_call_to_auth_service(): void
    {
        $authService = Mockery::mock(AuthService::class);
        $controller = new AuthController($authService);

        $expectedResponse = (object) ['profile' => 'ok'];

        $authService->shouldReceive('userProfile')->once()->andReturn($expectedResponse);

        $response = $controller->userProfile();

        $this->assertSame($expectedResponse, $response);
    }

    public function test_user_logout_forwards_call_to_auth_service(): void
    {
        $authService = Mockery::mock(AuthService::class);
        $controller = new AuthController($authService);

        $expectedResponse = (object) ['logout' => 'ok'];

        $authService->shouldReceive('userLogout')->once()->andReturn($expectedResponse);

        $response = $controller->userLogout();

        $this->assertSame($expectedResponse, $response);
    }
}

