<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\LoginRequest;
use Tests\Helper\FormRequestValidatorHelper;
use Tests\TestCase;

class LoginRequestValidationTest extends TestCase
{
    public function test_login_requires_email_with_custom_message(): void
    {
        $request = new LoginRequest;
        $validator = FormRequestValidatorHelper::make($request, []);

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter the registered email address.', $validator->errors()->first('email'));
    }

    public function test_login_rejects_invalid_email_with_custom_message(): void
    {
        $request = new LoginRequest;
        $validator = FormRequestValidatorHelper::make($request, [
            'email' => 'not-an-email',
            'password' => '12345',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter a valid email address.', $validator->errors()->first('email'));
    }

    public function test_login_requires_password_with_custom_message(): void
    {
        $request = new LoginRequest;
        $validator = FormRequestValidatorHelper::make($request, [
            'email' => 'test@example.com',
        ]);

        $this->assertTrue($validator->fails());
        $this->assertSame('Please enter your password.', $validator->errors()->first('password'));
    }

    public function test_login_passes_with_valid_email_and_password(): void
    {
        $request = new LoginRequest;
        $validator = FormRequestValidatorHelper::make($request, [
            'email' => 'user@example.com',
            'password' => 'secret',
        ], enforceAuthorize: true);

        $this->assertFalse($validator->fails());
    }
}
