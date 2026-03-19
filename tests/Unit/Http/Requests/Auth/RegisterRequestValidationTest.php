<?php

namespace Tests\Unit\Http\Requests\Auth;

use App\Http\Requests\RegisterRequest;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class RegisterRequestValidationTest extends TestCase
{
    private ?string $originalDefaultConnection = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->originalDefaultConnection = config('database.default');

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        DB::purge('sqlite');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phone_number')->nullable();
            $table->string('role')->default('user');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('users');

        if ($this->originalDefaultConnection !== null) {
            config()->set('database.default', $this->originalDefaultConnection);
        }

        parent::tearDown();
    }

    private function baseValidPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Valid Name',
            'email' => 'test@example.com',
            'password' => 'password123',
            'phone_number' => '01012345678',
        ], $overrides);
    }

    public function test_register_requires_name_with_custom_message(): void
    {
        $request = new RegisterRequest();

        $validator = Validator::make(
            $this->baseValidPayload(['name' => null]),
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('The name field is required.', $validator->errors()->first('name'));
    }

    public function test_register_rejects_name_too_short_with_custom_message(): void
    {
        $request = new RegisterRequest();

        $validator = Validator::make(
            $this->baseValidPayload(['name' => 'John']),
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('The name must be at least 5 characters.', $validator->errors()->first('name'));
    }

    public function test_register_rejects_invalid_email_with_custom_message(): void
    {
        $request = new RegisterRequest();

        $validator = Validator::make(
            $this->baseValidPayload(['email' => 'not-an-email']),
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('The email must be a valid email address.', $validator->errors()->first('email'));
    }

    public function test_register_rejects_duplicate_email_with_custom_message(): void
    {
        $request = new RegisterRequest();

        DB::table('users')->insert([
            'name' => 'Existing',
            'email' => 'taken@example.com',
            'password' => 'hash',
            'phone_number' => '01012345678',
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $payload = $this->baseValidPayload(['email' => 'taken@example.com']);

        $validator = Validator::make($payload, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertSame('The email has already been taken.', $validator->errors()->first('email'));
    }

    public function test_register_requires_password_with_custom_message(): void
    {
        $request = new RegisterRequest();

        $validator = Validator::make(
            $this->baseValidPayload(['password' => null]),
            $request->rules(),
            $request->messages()
        );

        $this->assertTrue($validator->fails());
        $this->assertSame('The password field is required.', $validator->errors()->first('password'));
    }
}

