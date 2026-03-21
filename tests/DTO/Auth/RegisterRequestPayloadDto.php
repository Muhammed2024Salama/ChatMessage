<?php

namespace Tests\DTO\Auth;

use Tests\Helper\StrictTestDtoOverrides;

final class RegisterRequestPayloadDto
{
    public function __construct(
        public ?string $name = 'Valid Name',
        public string $email = 'test@example.com',
        public ?string $password = 'password123',
        public string $phone_number = '01012345678',
    ) {
    }

    public static function make(array $overrides = []): self
    {
        $dto = new self;

        StrictTestDtoOverrides::apply($dto, $overrides);

        return $dto;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'phone_number' => $this->phone_number,
        ];
    }
}
