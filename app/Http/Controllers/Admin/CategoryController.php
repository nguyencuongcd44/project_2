<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,',
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ]);
    
        // Kiểm tra lỗi validation và chuyển hướng
        $this->handleValidationErrors(self::ADMIN_ERRORS, $validator);

        if(Category::create(request()->all())){
            return redirect()->route('category.index')->with('admin_success', 'Tạo danh mục thành công.');
        }
        return redirect()->route('category.index')->with('admin_error', 'Tạo danh mục thất bại.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|unique:categories,name,' . $category->id,
        ], [
            'name.required' => 'Tên danh mục không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
        ]);
    
        // Kiểm tra lỗi validation và chuyển hướng
        $this->handleValidationErrors(self::ADMIN_ERRORS, $validator);

        if($category->update(request()->all())){
            return redirect()->route('category.index')->with('admin_success', 'Cập nhật danh mục thành công.');
        }
        return redirect()->route('category.index')->with('admin_error', 'Cập nhật danh mục thất bại.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if($category->delete()){
            return redirect()->route('category.index')->with('admin_success', 'Xóa danh mục thành công.');
        }
        return redirect()->route('category.index')->with('admin_error', 'Xóa danh mục thất bại.');
    }
}
