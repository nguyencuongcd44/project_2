<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    protected function deleteFolder($folderPath){
        if(file_exists($folderPath)){
            File::deleteDirectory(public_path($folderPath));
        }
    }

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
    public function store(ProductStoreRequest $request)
    {
        $validated = $request->validated();
        $pro_number = $validated['pro_number'];
        $folder_path = public_path('product_img/').$pro_number;
        $imgs_name = ''; 

        DB::beginTransaction();
        try {
            // tạo folder
            if(!file_exists($folder_path)){
                File::makeDirectory($folder_path, 0777, true);
            }

            // thumbnail
            if($validated['thumbnail_upload']){
                $thumbnail = $validated['thumbnail_upload'];
                $ext = $thumbnail->getClientOriginalExtension();
                $thumbnail_name = $pro_number.'.'.$ext;
                $thumbnail->move($folder_path, $thumbnail_name);
                $validated['thumbnail'] = $thumbnail_name;
            }

            // images
            if($validated['img_upload']){
                $imgs = $validated['img_upload'];

                $cnt= 1;
                foreach($imgs as $img){
                    $ext = $img->getClientOriginalExtension();
                    $img_name = $pro_number.'_'.$cnt.'.'.$ext;
                    $img->move($folder_path, $img_name);
                    $imgs_name .= $img_name.'|->';
                    $cnt ++;
                }
                $validated['image'] = $imgs_name;
            }
            
            Product::create($validated);
            DB::commit();

            return redirect()->route('product.index')->with('admin_success', 'Tạo sản phẩm thành công.');

        } catch (QueryException $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFolder($folder_path);
            
            Log::error('Lỗi truy vấn: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        } catch (\Exception $e) {
            // Xóa ảnh mới nếu có lỗi xảy ra
            $this->deleteFolder($folder_path);
            
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
        $imgs = [];
        if($product->image){
            $imgs = explode('|->', $product->image);
            $imgs = array_filter($imgs);
        }
        return view('admin.product.edit', compact(['product', 'imgs', 'cats']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $MAX_IMAGES = 6;
        $MAX_SIZE_MB = 2; // Dung lượng tối đa mỗi ảnh (MB)

        $post = $request->all();
        $post['image'] = '';
        $imgs = explode('|->', $post['sort']);
        $imgs = array_filter($imgs);
        $pro_number = $post['pro_number'];
        $folder_path = public_path('product_img/').$pro_number;
        
        //check số lượng ảnh
        if(count($imgs) > $MAX_IMAGES){
            Log::error('Client:Upload quá '. $MAX_IMAGES.' ảnh.', [
                'action' => request()->route()->getActionName(),
            ]);
            return redirect()->back()->with('admin_error', 'Bạn chỉ được tải lên tối đa '. $MAX_IMAGES.' ảnh.');
        }

        //check dung lượng mỗi ảnh
        if(isset($post['new_images'])){
            $over_flg = 0;
            foreach($post['new_images'] as $new_image){
                if($new_image->getSize() > $MAX_SIZE_MB * 1024 * 1024){
                    $over_flg = 1;
                }
            }
            if($over_flg == 1){
                Log::error('Client:Upload ảnh quá '. $MAX_SIZE_MB.' MB.', [
                    'action' => request()->route()->getActionName(),
                ]);
                return redirect()->back()->with('admin_error', 'Dung lượng mỗi ảnh chi tiết không được vượt quá '. $MAX_SIZE_MB.' MB.');
            }

            // Lấy danh sách ảnh chi tiết mới 
            $newImages = $request->file('new_images');

            // Tạo một mảng kết hợp để dễ dàng truy cập vào các file ảnh mới dựa trên tên file của chúng
            $newImagesMap = [];
            foreach ($newImages as $file) {
                $newImagesMap[$file->getClientOriginalName()] = $file;
            }
           
        }

        $new_folder_path = public_path('product_img/').'__'.$pro_number;
        // tạo folder
        if(!file_exists($folder_path)){
            File::makeDirectory(public_path('product_img/').'__'.$pro_number, 0777, true);

        }else{
            File::copyDirectory($folder_path, $new_folder_path);
            chmod($new_folder_path, 0777); 
        }
        
        DB::beginTransaction();
        try {
            // thumbnail
            if(isset($post['thumbnail'])){
                // xóa thumbnail cũ 
                $oldThumbnail = File::glob($new_folder_path . '/' . $pro_number . '.*');

                if (count($oldThumbnail) > 0) {
                    unlink($oldThumbnail[0]);
                }
                
                // thêm thumbnail mới
                $newThumbnail = $post['thumbnail'];
                $newThumbnailExt = $newThumbnail->getClientOriginalExtension();
                $newThumbnail->move($new_folder_path, $pro_number.'.'.$newThumbnailExt);
                $post['thumbnail'] = $pro_number.'.'.$newThumbnailExt;
            }

            $sort = 1;
            foreach($imgs as $img){
                // có ảnh cũ
                if(File::exists($new_folder_path.'/'.$img)){
                    $parts = explode('.', $img);
                    $oldImageExt = end($parts);
                    $newImagePath = $new_folder_path.'/'.'__'.$pro_number.'_'.$sort.'.'.$oldImageExt;
                    copy($new_folder_path.'/'.$img, $newImagePath);
                    $sort ++ ;

                }else if(isset($newImagesMap[$img])){ 
                    // khi là ảnh mới
                    $parts = explode('.', $img);
                    $newImageExt = end($parts);
                    $newImage = $newImagesMap[$img];
                    $newImage->move($new_folder_path, '__'.$pro_number.'_'.$sort.'.'.$newImageExt);
                    $sort ++ ;
                }
            }

            // xóa các ảnh cũ 
            $oldImages = File::glob($new_folder_path . '/' . $pro_number . '_*');
            if(count($oldImages) > 0){
                foreach ($oldImages as $file) {
                    unlink($file);
                }
            }

            // sửa tên ảnh đã thêm ban trên thành tên đúng : từ "__ten_anh.png"  thành "ten_anh.png"
            $files = File::glob($new_folder_path . '/' . '__' . $pro_number . '_*');
            foreach ($files as $file) {
                $explode = explode('/', $file);
                $imageName = end($explode);

                // Tên file mới sẽ bỏ "__" ở đầu
                $newFilename = substr($imageName, 2); // Bỏ "__" và giữ phần còn lại
                
                // Đổi tên file
                rename($new_folder_path . '/' . $imageName, $new_folder_path . '/' . $newFilename);
                $post['image'] .= $newFilename.'|->';
            }

            //Update dữ liệu DB
            $product->update($post);

            DB::commit();

            // xóa folder cũ , đổi tên folder mới
            File::deleteDirectory($folder_path);
        
            rename($new_folder_path, $folder_path);
            chmod($folder_path, 0777); 

            return redirect()->route('product.index')->with('admin_success', 'Cập nhật sản phẩm thành công.');

        } catch (QueryException $e) {

            $this->deleteFolder($new_folder_path);
            
            Log::error('Lỗi truy vấn: ', [
                'action' => request()->route()->getActionName(),
                'line' => $e->getLine(),
                'error_message' => $e->getMessage(),
                'inputs' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('admin_error', 'Đã xảy ra lỗi.');

        } catch (\Exception $e) {

            $this->deleteFolder($new_folder_path);
            
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
    public function destroy(Product $product)
    {
        // Xóa ảnh
        if (File::exists(public_path('/images/'.$product->image))) {
            File::delete(public_path('/images/'.$product->image));
        }
        if($product->delete()){
            return redirect()->route('product.index')->with('admin_success', 'Xóa sản phẩm thành công.');
        }
        return redirect()->route('product.index')->with('admin_error', 'Xóa sản phẩm thất bại.');
    }
}
