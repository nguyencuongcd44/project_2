<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // Hằng số để phân loại lỗi
    const FRONT_END_ERRORS = 'frontErrors';
    const ADMIN_ERRORS = 'adminErrors';
    
    // Phương thức xử lý lỗi validation
    public function handleValidationErrors($target, $validator)
    {
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, $target)
                ->withInput();
        }
    }
}
