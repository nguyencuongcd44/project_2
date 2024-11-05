<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name'          => 'required|string|unique:products,name,' .$this->route('product')->id,
            'thumbnail_upload'  => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*'      => 'image|mimes:jpeg,png,jpg,gif', 
            'contents'      => 'required',
            'price'         => 'required|numeric|digits_between:4,10',
            'category_id'   => 'required',
            'status'        => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.unique' => 'Tên sản phẩm này đã tồn tại, vui lòng chọn tên khác.',

            'thumbnail_upload.image' => 'Ảnh đại diện phải là một file hình ảnh.',
            'thumbnail_upload.mimes' => 'Ảnh đại diện chỉ có thể thuộc các định dạng: jpeg, png, jpg, gif.',
            'thumbnail_upload.max' => 'Dung lượng ảnh đại diện không được vượt quá 2MB.',
            
            'images.*.image' => 'Mỗi tệp tải lên trong ảnh chi tiết phải là hình ảnh.',
            'images.*.mimes' => 'Ảnh chi tiết chỉ có thể thuộc các định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Dung lượng mỗi ảnh chi tiết không được vượt quá 2MB.',
            
            'contents.required' => 'Vui lòng nhập nội dung mô tả sản phẩm.',
            
            'price.required' => 'Vui lòng nhập giá sản phẩm.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'price.digits_between' => 'Giá sản phẩm phải nằm trong khoảng từ 4 đến 10 chữ số.',
            
            'category_id.required' => 'Vui lòng chọn danh mục cho sản phẩm.',
            
            'status.required' => 'Vui lòng chọn trạng thái cho sản phẩm.'
        ];
    }
}
