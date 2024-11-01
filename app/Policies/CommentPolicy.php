<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Comments;

class CommentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __constructor()
    {
        //
    }

    public function my_comment($customer, Comments $comment)
    {
        // Lấy người dùng từ guard tùy chỉnh 
        $customer = Auth::guard('cus')->user();
        
        // Kiểm tra nếu người dùng là chủ sở hữu của comment
        return $customer && $customer->id === $comment->user_id;
    }
}
