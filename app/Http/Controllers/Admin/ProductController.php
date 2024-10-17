<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy tất cả sản phẩm cùng với tên danh mục của chúng
        $products = Product::with('category')->paginate(5);

        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = Category::orderBy('id', 'DESC')->get();
        return view('admin.product.create', compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'img_upload'     => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name'          => 'required|unique:products',
            'contents'      => 'required',
            'price'         => 'required|numeric|digits_between:1,8',
            'category_id'   => 'required',
            'status'        => 'required'
        ]);

        $image_name = ''; //khởi tạo biến chứa tên ảnh
        try {
            //kiểm tra sự hiện diện của ảnh mới
            if($request->hasFile('img_upload')){
                // tạo tên ảnh
                $image = $request->all()['img_upload'];
                $carbon = Carbon::now();
                $image_name = $carbon->format('YmdHis').'_'.$image->getClientOriginalName();

                //Lưu ảnh mới
                if($image->move(public_path('images'), $image_name)){
                    $request->merge(['image' => $image_name]);
                    Product::create(request()->all());

                }
            }

            DB::commit();

            return redirect()->route('product.index');

        } catch (\Exception $e) {
            DB::rollBack();

            // Xóa ảnh mới nếu có lỗi xảy ra
            if (File::exists(public_path('/images/'.$image_name))) {
                File::delete(public_path('/images/'.$image_name));
            }

            return back()->withErrors('Creating failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $cats = Category::orderBy('name', 'ASC')->get();
        return view('admin.product.edit', compact(['product', 'cats']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        
        // validate dữ liệu (tên sản phẩm bắt buộc và duy nhất loại trừ tên sản phẩm hiện tại)
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('products')->ignore($product->id),
            ],
            'img_upload'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'price'     => 'required|numeric|digits_between:1,8', 
            'contents'  => 'required',
        ]);
        
        //cách xử lý update ảnh dưới đây hơi cồng kềnh, nên tham khảo cách update ảnh khác ?
        DB::beginTransaction();

        $old_image = ''; //khởi tạo biến chứa tên ảnh cũ
        $image_name = ''; //khởi tạo biến chứa tên ảnh mới
        try {
            //kiểm tra sự hiện diện của ảnh mới
            if($request->hasFile('img_upload')){
                // tạo tên ảnh
                $image = $request->all()['img_upload'];
                $carbon = Carbon::now();
                $image_name = $carbon->format('YmdHis').'_'.$image->getClientOriginalName();

                //Lưu ảnh mới
                if($image->move(public_path('images'), $image_name)){
                    $old_image = $product->image;
                    $request->merge(['image' => $image_name]);
                }
            }

            //Update dữ liệu
            $product->update(request()->all());

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            // Xóa ảnh mới nếu có lỗi xảy ra
            if (File::exists(public_path('/images/'.$image_name))) {
                File::delete(public_path('/images/'.$image_name));
            }

            return back()->withErrors('Updating failed');
        }

        // Xóa ảnh cũ
        if (File::exists(public_path('/images/'.$old_image))) {
            File::delete(public_path('/images/'.$old_image));
        }

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Xóa ảnh
        if (File::exists(public_path('/images/'.$product->image))) {
            File::delete(public_path('/images/'.$product->image));
        }
        $product->delete();
        return redirect()->route('product.index');
    }
}
