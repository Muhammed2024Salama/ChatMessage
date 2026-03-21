<?php

namespace Tests\Helper;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidatorInstance;

final class FormRequestValidatorHelper
{
    public static function make(FormRequest $request, array $data, bool $enforceAuthorize = false): ValidatorInstance
    {
        if ($enforceAuthorize && ! $request->authorize()) {
            throw new \RuntimeException('Unauthorized FormRequest.');
        }

        return Validator::make($data, $request->rules(), $request->messages());
    }
}
