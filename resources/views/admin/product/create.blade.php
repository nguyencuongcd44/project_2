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
</style>

<h1>Form Create Product</h1>
<form action="{{ route('product.store') }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    <!-- Nội dung form -->
    <div class="col-md">
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Input Name">
        </div>

        <div class="form-group">
            <label for="">Mã sản phẩm</label>
            <input type="text" class="form-control" name="pro_number" value="{{ old('pro_number') }}" placeholder="Nhập mã sản phẩm">
        </div>

        <div class="form-group">
            <label for="">Thumbnail</label>
            <img id="image_preview" name="image" alt="Thumbnail Preview">
            <div>
                <input type="file" id="thumbnail_upload" name="thumbnail_upload" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <label for="">Hình ảnh chi tiết</label>
            <div id="image_container"></div>
            <div>
                <input type="file" id="img_upload" name="img_upload[]" accept="image/*" multiple>
            </div>
        </div>

        <div class="form-group">
            <label for="">Giá</label>
            <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Input price">
        </div>

        <div class="form-group">
            <label for="">Miêu Tả</label>
            <textarea class="form-control" rows="8" name="contents" placeholder="Input Content">{{ old('contents') }}</textarea>
        </div>

        <div class="form-group">
            <label for="">Danh Mục</label>
            <select name="category_id" id="category" class="form-control" required="required">
                @foreach($cats as $cat)
                    <option value="{{$cat->id}}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="">Trạng Thái</label>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="1" checked="checked">
                    Hiển thị
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="0">
                    Ẩn
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        // Hiển thị thumbnail
        $('#thumbnail_upload').change(function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        // Hiển thị hình ảnh chi tiết khi chọn tệp
        $('#img_upload').change(function(e) {
            const files = e.target.files; // Lấy tất cả tệp đã chọn
            $('#image_container').empty(); // Xóa các hình ảnh đã hiển thị trước đó

            $.each(files, function(index, file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Tạo phần tử hình ảnh mới với nút xóa
                    const imgElement = $(`
                        <div class="image_item">
                            <img src="${e.target.result}" alt="Detail Image">
                            <button type="button" class="remove_image">&times;</button>
                        </div>
                    `);
                    $('#image_container').append(imgElement);
                };
                reader.readAsDataURL(file); // Đọc tệp hình ảnh
            });

            // Khởi tạo chức năng drag and drop
            initSortable();
        });

        // Xóa hình ảnh chi tiết
        $(document).on('click', '.remove_image', function() {
            $(this).closest('.image_item').remove(); // Loại bỏ phần tử cha
        });

        // Chức năng drag and drop
        function initSortable() {
            $('#image_container').sortable({
                items: '.image_item', // Chỉ định các item có thể kéo
                cursor: 'move', // Con trỏ khi kéo
                update: function(event, ui) {
                    // Xử lý khi vị trí hình ảnh được thay đổi
                    console.log('Vị trí đã thay đổi!');
                }
            });
        }
    });
</script>

@stop
