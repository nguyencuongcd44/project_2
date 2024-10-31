<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AdminRegisterRequest extends FormRequest
{
    /**
     * Override phương thức failedValidation để chuyển lỗi vào error bag tùy chỉnh.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator, 'adminErrors') // Chuyển lỗi vào error bag tùy chỉnh 'adminErrors'
                ->withInput()
        );
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
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'role.required' => 'Vai trò là bắt buộc.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'confirm_password.required' => 'Xác nhận mật khẩu là bắt buộc.',
            'confirm_password.same' => 'Xác nhận mật khẩu phải giống với mật khẩu.',
        ];
    }
}
