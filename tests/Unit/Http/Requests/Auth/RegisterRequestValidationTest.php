<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\Helper\FormRequestValidatorHelper;
use Tests\TestCase;
use Tests\Traits\MakesRegisterRequestPayload;

class RegisterRequestValidationTest extends TestCase
{
    use RefreshDatabase;
    use MakesRegisterRequestPayload;

    public function test_register_requires_name_with_custom_message(): void
    {
        $request = new RegisterRequest;
        $validator = FormRequestValidatorHelper::make($request, $this->makeRegisterPayload(['name' => null]));

        $this->assertTrue($validator->fails());
        $this->assertSame('The name field is required.', $validator->errors()->first('name'));
    }

    public function test_register_rejects_name_too_short_with_custom_message(): void
    {
        $request = new RegisterRequest;
        $validator = FormRequestValidatorHelper::make($request, $this->makeRegisterPayload(['name' => 'John']));

        $this->assertTrue($validator->fails());
        $this->assertSame('The name must be at least 5 characters.', $validator->errors()->first('name'));
    }

    public function test_register_rejects_invalid_email_with_custom_message(): void
    {
        $request = new RegisterRequest;
        $validator = FormRequestValidatorHelper::make($request, $this->makeRegisterPayload(['email' => 'not-an-email']));

        $this->assertTrue($validator->fails());
        $this->assertSame('The email must be a valid email address.', $validator->errors()->first('email'));
    }

    public function test_register_rejects_duplicate_email_with_custom_message(): void
    {
        $request = new RegisterRequest;

        DB::table('users')->insert([
            'name' => 'Existing',
            'email' => 'taken@example.com',
            'password' => 'hash',
            'phone_number' => '01012345678',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $validator = FormRequestValidatorHelper::make(
            $request,
            $this->makeRegisterPayload(['email' => 'taken@example.com'])
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('The email has already been taken.', $validator->errors()->first('email'));
    }

    public function test_register_requires_password_with_custom_message(): void
    {
        $request = new RegisterRequest;
        $validator = FormRequestValidatorHelper::make($request, $this->makeRegisterPayload(['password' => null]));

        $this->assertTrue($validator->fails());
        $this->assertSame('The password field is required.', $validator->errors()->first('password'));
    }

    public function test_register_passes_with_valid_payload(): void
    {
        $request = new RegisterRequest;
        $validator = FormRequestValidatorHelper::make($request, $this->makeRegisterPayload());

        $this->assertFalse($validator->fails());
    }
}
