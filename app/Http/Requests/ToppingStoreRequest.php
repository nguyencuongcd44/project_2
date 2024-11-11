<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ToppingStoreRequest extends FormRequest
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
            'name'          => 'required|string|max:100',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'         => 'required|numeric|digits_between:4,10',
            'type'          => 'required|integer|between:0,1',
            'status'        => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên topping.',
            'name.max' => 'Tên topping không được dài quá 100 ký tự.',

            'image.required' => 'Vui lòng tải lên ảnh đại diện.',
            'image.image' => 'Ảnh đại diện phải là một file hình ảnh.',
            'image.mimes' => 'Ảnh đại diện chỉ có thể thuộc các định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Dung lượng ảnh đại diện không được vượt quá 2MB.',
            
            'price.required' => 'Vui lòng nhập giá topping.',
            'price.numeric' => 'Giá topping phải là một số.',
            'price.digits_between' => 'Giá topping phải nằm trong khoảng từ 4 đến 10 chữ số.',

            'type.required' => 'Vui lòng chọn loại topping.',
            
            'status.required' => 'Vui lòng chọn trạng thái cho topping.'
        ];
    }
}
