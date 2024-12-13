<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Traits\PasswordValidationTrait;
use App\Traits\FailedValidationTrait;

class AdminRegisterRequest extends FormRequest
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
        $this->handleFailedValidation($validator, self::ADMIN_ERRORS);
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
        ], $this->passwordRules());// Sử dụng rules từ Trait
    }

    public function messages(): array
    {
        return array_merge([
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'role.required' => 'Vai trò là bắt buộc.',
        ], $this->passwordMessages());// Sử dụng messages từ Trait
    }
}
