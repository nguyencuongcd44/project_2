<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class AccountRegisterRequest extends FormRequest
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
                ->withErrors($validator, 'frontErrors') // Chuyển lỗi vào error bag tùy chỉnh 'adminErrors'
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
            'name' => 'required|min:6|max:100',
            'phone' => 'required|regex:/^\+?[0-9]{9,13}$/|unique:customers',
            'email' => 'required|email|min:6|max:100|unique:customers',
            'password' => 'required|min:4',
            'confimr_password' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.min' => 'Tên phải có ít nhất :min ký tự.',
            'name.max' => 'Tên không được vượt quá :max ký tự.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không đúng định dạng. Vui lòng nhập số điện thoại hợp lệ.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.min' => 'Email phải có ít nhất :min ký tự.',
            'email.max' => 'Email không được vượt quá :max ký tự.',
            'email.unique' => 'Email đã tồn tại.',

            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',

            'confimr_password.required' => 'Vui lòng xác nhận mật khẩu.',
            'confimr_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.',
        ];
    }
}
