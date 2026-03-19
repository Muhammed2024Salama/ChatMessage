<?php

namespace Tests\Unit\Http\Requests\Chat;

use App\Enums\MessageEntityType;
use App\Http\Requests\Chat\SendMessageRequest;
use App\Helper\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Mockery;
use Tests\DTO\Chat\SendMessageDto;
use Tests\TestCase;

class SendMessageRequestValidationTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    private function makeRequestWithInput(array $input): SendMessageRequest
    {
        return tap(
            new class extends SendMessageRequest {
                public function callFailedValidation(Validator $validator)
                {
                    return $this->failedValidation($validator);
                }
            },
            fn (SendMessageRequest $request) => $request->merge($input),
        );
    }

    public function test_failed_validation_returns_custom_error_when_entity_type_present_but_entity_id_missing(): void
    {
        $validator = Mockery::mock(Validator::class);

        $payload = SendMessageDto::make([
            'entity_type' => MessageEntityType::PROPERTY->value,
            'entity_id' => null,
        ])->toArray();

        $request = $this->makeRequestWithInput(array_merge(
            ['sender' => 1, 'receiver' => 2],
            $payload
        ));

        $expected = ResponseHelper::error(
            'error',
            'Entity ID is required when Entity Type is provided.',
            422
        );

        /** @var JsonResponse $response */
        $response = $request->callFailedValidation($validator);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame($expected->getData(true), $response->getData(true));
    }

    public function test_failed_validation_returns_custom_error_when_sender_equals_receiver(): void
    {
        $validator = Mockery::mock(Validator::class);

        $payload = SendMessageDto::make()->toArray();

        $request = $this->makeRequestWithInput(array_merge(
            ['sender' => 1, 'receiver' => 1],
            $payload
        ));

        $expected = ResponseHelper::error(
            'error',
            'Sender and receiver cannot be the same user.',
            422
        );

        /** @var JsonResponse $response */
        $response = $request->callFailedValidation($validator);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame($expected->getData(true), $response->getData(true));
    }

    public function test_failed_validation_returns_same_custom_error_for_project_missing_entity_id(): void
    {
        $validator = Mockery::mock(Validator::class);

        $payload = SendMessageDto::make([
            'entity_type' => MessageEntityType::PROJECT->value,
            'entity_id' => null,
        ])->toArray();

        $request = $this->makeRequestWithInput(array_merge(
            ['sender' => 1, 'receiver' => 2],
            $payload
        ));

        $expected = ResponseHelper::error(
            'error',
            'Entity ID is required when Entity Type is provided.',
            422
        );

        /** @var JsonResponse $response */
        $response = $request->callFailedValidation($validator);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertSame(422, $response->getStatusCode());
        $this->assertSame($expected->getData(true), $response->getData(true));
    }
}

