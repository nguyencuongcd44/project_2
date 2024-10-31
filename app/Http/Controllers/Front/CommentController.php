<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Models\Comments;
use App\Models\User;
use Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;


class CommentController extends Controller
{
    public function post_cmt(Request $request, $product)
    {
        if(!Auth::guard('cus')->check()){
            return redirect()->back()->with('error', 'Bạn chưa đăng nhập.');
        }
        
        $request->validate([
            'comment' => 'required',
        ],[
            'comment.required' => 'Nội dung bình luận không được để trống.',
        ]);

        $comment = e($request->comment);
        $data['user_id'] = Auth::guard('cus')->user()->id;
        $data['product_id'] = $product;
        $data['text'] = $comment;
        Comments::create($data);

        return redirect()->back();
    }

    public function update_cmt(Request $request)
    {
        $id = $request->id;
        $comment = Comments::find($id);
        $text = $request->text;

        if(auth()->guard('cus')->user()->can('my-comment',$comment)){
            Comments::where('id', $id)->update(['text' => $text]);
        }
    }

    public function delete_cmt($id)
    {
        $comment = Comments::find($id);
        if(auth()->guard('cus')->user()->can('my-comment',$comment)){
            if($comment->delete()){
                return redirect()->back()->with('success', 'Xóa bình luận thành công.');
            }
            return redirect()->back()->with('error', 'Xóa bình luận thất bại.');
        }
    }
}
