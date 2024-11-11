<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ToppingStoreRequest;
use App\Http\Requests\ToppingUpdateRequest;
use App\Models\Topping;
use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ToppingController extends Controller
{
    protected function deleteFile($folderPath, $file_name){
        if(file_exists($folderPath.$file_name)){
            File::delete($folderPath.$file_name);
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toppings = Topping::with('products')->get();
        return view('admin.topping.index', compact('toppings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('admin.topping.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ToppingStoreRequest $request)
    {
        $post = $request->all();
        $productIds = isset($post['products']) ? $post['products'] : [];
        $validated = $request->validated();
        $folder_path = public_path('topping_img/');
        DB::beginTransaction();
        try {
            // tạo folder
            if(!file_exists($folder_path)){
                File::makeDirectory($folder_path, 0777, true);
            }

            // image
            if($validated['image']){
                $image = $validated['image'];
                $ext = $image->getClientOriginalExtension();
                $image_name = Str::studly(Str::ascii($validated['name'])).Carbon::now()->format('YmdHis').'.'.$ext;
                $image->move($folder_path, $image_name);
                $validated['image'] = $image_name;
            }

            $topping = Topping::create($validated);
            if($validated['type'] == 1 && count($productIds) > 0){
                $topping->products()->attach($productIds);
            }
            DB::commit();

            return redirect()->route('topping.index')->with('admin_success', 'Tạo topping thành công.');

        } catch (QueryException $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFile($folder_path, $image_name);
            
            Log::error('Lỗi truy vấn: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        } catch (\Exception $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFile($folder_path, $image_name);
            
            Log::error('Lỗi không xác định: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topping = Topping::with('products')->find($id);
        $products = Product::get();
        $linkedProductIds = $topping->products->pluck('id')->toArray();
        return view('admin.topping.edit', compact(['topping', 'products', 'linkedProductIds']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ToppingUpdateRequest $request, $id)
    {
        $post = $request->all();
        $productIds = isset($post['products']) ? $post['products'] : [];
        $topping = Topping::findOrFail($id);
        $currentImage = $topping->image;
        $validated = $request->validated();
        $folder_path = public_path('topping_img/');

        DB::beginTransaction();
        try {
            // tạo folder
            if(!file_exists($folder_path)){
                File::makeDirectory($folder_path, 0777, true);
            }

            // thêm ảnh mới
            if(isset($validated['newImage'])){
                $newImage = $validated['newImage'];
                $ext = $newImage->getClientOriginalExtension();
                $newImage_name = Str::studly(Str::ascii($validated['name'])).Carbon::now()->format('YmdHis').'.'.$ext;
                $newImage->move($folder_path, $newImage_name);
                $validated['image'] = $newImage_name;
            }

            // dd($validated);
            $topping->update($validated);
            if($validated['type'] == 1 && count($productIds) > 0){
                $topping->products()->sync($productIds);

            }else{
                $topping->products()->detach();
            }

            DB::commit();

            // xoá ảnh hiện tại
            if(isset($validated['newImage'])){
                if(file_exists($folder_path.$currentImage)){
                    File::delete($folder_path.$currentImage);
                }
            }

            return redirect()->route('topping.index')->with('admin_success', 'Update topping thành công.');

        } catch (QueryException $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFile($folder_path, $newImage_name);
            
            Log::error('Lỗi truy vấn: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        } catch (\Exception $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFile($folder_path, $newImage_name);
            
            Log::error('Lỗi không xác định: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
