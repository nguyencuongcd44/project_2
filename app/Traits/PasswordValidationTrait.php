<?php 

namespace App\Traits;

trait PasswordValidationTrait{
    // Rules chung cho validation mật khẩu
    public function passwordRules(): array {
        return [
            'password' => 'required|min:4',
            'confirm_password' => 'required|same:password',
        ];
    }

    // Messages chung cho validation mật khẩu
    public function passwordMessages(): array {
        return [
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.',
        ];
    }
}