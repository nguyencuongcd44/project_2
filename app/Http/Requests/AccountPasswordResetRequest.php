<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\PasswordValidationTrait;
use Illuminate\Contracts\Validation\Validator;
use App\Traits\FailedValidationTrait;

class AccountPasswordResetRequest extends FormRequest
{
    use PasswordValidationTrait; // Sử dụng Trait
    use FailedValidationTrait; // Sử dụng Trait
    /**
     * Override phương thức failedValidation để chuyển lỗi vào error bag tùy chỉnh.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $this->handleFailedValidation($validator, self::FRONT_END_ERRORS);
    }

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
        return array_merge([
            'token' => 'required|exists:password_reset_tokens,token',
        ], $this->passwordRules());// Sử dụng rules từ Trait
    }

    public function messages(): array
    {
        return array_merge([
            'token.required' => 'Không nhận diện được token.',
            'token.exists' => 'Token không hợp lệ.',
        ], $this->passwordMessages()); // Sử dụng messages từ Trait
    }
}
