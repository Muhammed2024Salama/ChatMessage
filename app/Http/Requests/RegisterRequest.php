<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => $this->nameRules(),
            'email' => $this->emailRules(),
            'password' => $this->passwordRules(),
            'phone_number' => $this->phoneNumberRules(),
        ];
    }

    /**
     * Get the validation rules for the name.
     *
     * @return string
     */
    private function nameRules(): string
    {
        return 'required|min:5|max:150';
    }

    /**
     * Get the validation rules for the email.
     *
     * @return string
     */
    private function emailRules(): string
    {
        return 'required|email|unique:users';
    }

    /**
     * Get the validation rules for the password.
     *
     * @return string
     */
    private function passwordRules(): string
    {
        return 'required|min:5|max:25';
    }

    /**
     * Get the validation rules for the phone number.
     *
     * @return string
     */
    private function phoneNumberRules(): string
    {
        return 'required|digits:10';
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 5 characters.',
            'name.max' => 'The name may not be greater than 150 characters.',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 5 characters.',
            'password.max' => 'The password may not be greater than 25 characters.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.digits' => 'The phone number must be 10 digits.',
        ];
    }
}
