<?php 

namespace App\Traits;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait FailedValidationTrait{
    const FRONT_END_ERRORS = 'frontErrors';
    const ADMIN_ERRORS = 'adminErrors';
    /**
     * Override phương thức failedValidation để chuyển lỗi vào error bag tùy chỉnh.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     */
    public function handleFailedValidation(Validator $validator, string $target)
    {
        throw new HttpResponseException(
            redirect()->back()
                ->withErrors($validator, $target) // Đưa lỗi vào error bag tùy chỉnh
                ->withInput()
        );
    }
}