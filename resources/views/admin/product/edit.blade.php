@extends('admin.general')
@section('main')

<style>
    #image_preview {
        max-width: 400px;
        height: auto;
        padding: 10px 0;
        border: 2px dashed #ccc; 
        margin-bottom: 10px; 
    }
    #image_container {
        display: flex; 
        flex-wrap: wrap; 
        margin-bottom: 10px;
        border: 1px solid #ccc; 
        padding: 10px; 
        border-radius: 5px; 
        background-color: #f9f9f9; 
    }
    .image_item {
        position: relative;
        margin-right: 10px; 
        margin-bottom: 10px; 
        cursor: move; 
    }
    .image_item img {
        max-width: 100px; 
        display: block;
    }
    .remove_image {
        position: absolute; 
        top: 0;
        right: 0;
        background: red; 
        color: white;
        border: none; 
        border-radius: 50%;
        width: 20px; 
        height: 20px; 
        cursor: pointer; 
    }
    .pro_number{
        cursor: not-allowed;
    }
</style>

<h1>Form Create Product</h1>
<form action="{{ route('product.update', $product->id) }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    @method('PUT') 
    

    <div class="col-md">
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="Input Name">
        </div>

        <div class="form-group">
            <label for="">Mã sản phẩm</label>
            <input type="text" class="form-control pro_number" name="pro_number" value="{{ $product->pro_number }}" placeholder="Nhập mã sản phẩm" readonly>
        </div>

        <div class="form-group">
            <label for="">Thumbnail</label>
            <img id="image_preview" value="{{ $product->pro_number }}" src="/product_img/{{ $product->pro_number }}/{{ $product->thumbnail }}" alt="{{ $product->name }}" name="thumbnail">
            <div>
                <input type="file" id="thumbnail_upload" name="thumbnail" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <label for="">Hình ảnh chi tiết</label>
            <input type="hidden" name="sort" id="sort" value="">

            <div id="image_container">
                @foreach ($imgs as $img)
                    <div class="image_item" data-image="{{ $img }}">
                        <img src="/product_img/{{ $product->pro_number }}/{{ $img }}" alt="{{ $product->name }}">
                        <button type="button" class="remove_image">&times;</button>
                    </div>
                @endforeach
            </div>
            <input type="file" id="img_upload" name="new_images[]" accept="image/*" multiple>
        </div>

        <div class="form-group">
            <label for="">Giá</label>
            <input type="number" class="form-control" name="price" value="{{ $product->price }}" placeholder="Input price">
        </div>

        <div class="form-group">
            <label for="">Miêu Tả</label>
            <textarea class="form-control" rows="8" name="contents" placeholder="Input Content">{{ $product->contents }}</textarea>
        </div>

        <div class="form-group">
            <label for="">Danh Mục</label>
            <select name="category_id" id="category" class="form-control" required="required">
                @foreach($cats as $cat)
                    <option value="{{$cat->id}}" {{ $product->category_id == $cat->id ? 'selected' : '' }} >{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="">Trạng Thái</label>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="1" {{ $product->status == 1 ? 'checked' : '' }}>
                    Hiển thị
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="0" {{ $product->status == 0 ? 'checked' : '' }}>
                    Ẩn
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </div>
</form>


<script>
    $(document).ready(function() {
        const MAX_IMAGES = 6;
        const MAX_SIZE_MB = 2;

        $('#img_upload').change(function(e) {
            const existingImages = $('#image_container .image_item').length;
            const newImages = e.target.files;

            if (existingImages + newImages.length > MAX_IMAGES) {
                alert(`Bạn chỉ được tải lên tối đa ${MAX_IMAGES} ảnh.`);
                $(this).val('');
                return;
            }

            for (const file of newImages) {
                if (file.size > MAX_SIZE_MB * 1024 * 1024) {
                    alert(`Dung lượng mỗi ảnh không được vượt quá ${MAX_SIZE_MB} MB.`);
                    $(this).val('');
                    return;
                }
            }

            $.each(newImages, function(index, file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgElement = $(`
                        <div class="image_item" data-image="${file.name}">
                            <img src="${e.target.result}" alt="Detail Image">
                            <button type="button" class="remove_image">&times;</button>
                        </div>
                    `);
                    $('#image_container').append(imgElement);
                    
                    let imageOrder = [];
                    $('#image_container .image_item').each(function() {
                        imageOrder.push($(this).data('image'));
                    });
                    $('#sort').val(imageOrder.join('|->'));
                };
                

                reader.readAsDataURL(file);
            });
        });

        $(document).on('click', '.remove_image', function() {
            $(this).closest('.image_item').remove();
            let imageOrder = [];
            $('#image_container .image_item').each(function() {
                imageOrder.push($(this).data('image'));
            });
            $('#sort').val(imageOrder.join('|->'));
        });

        $('#image_container').sortable({
            items: '.image_item',
            cursor: 'move',
            update: function() {
                let imageOrder = [];
                $('#image_container .image_item').each(function() {
                    imageOrder.push($(this).data('image'));
                });
                $('#sort').val(imageOrder.join('|->'));
            }
        });


        // Khởi tạo giá trị ban đầu cho input hidden images
        let initialImages = [];
        $('#image_container .image_item').each(function() {
            initialImages.push($(this).data('image'));
        });
        $('#sort').val(initialImages.join('|->'));


    });
</script>

@stop
