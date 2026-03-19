<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class LoginRequestValidationTest extends TestCase
{
    public function test_login_requires_email_with_custom_message(): void
    {
        $request = new LoginRequest();

        $validator = Validator::make([], $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter the registered email address.', $validator->errors()->first('email'));
    }

    public function test_login_rejects_invalid_email_with_custom_message(): void
    {
        $request = new LoginRequest();

        $validator = Validator::make(
            ['email' => 'not-an-email', 'password' => '12345'],
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter a valid email address.', $validator->errors()->first('email'));
    }

    public function test_login_requires_password_with_custom_message(): void
    {
        $request = new LoginRequest();

        $validator = Validator::make(
            ['email' => 'test@example.com'],
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter your password.', $validator->errors()->first('password'));
    }
}

