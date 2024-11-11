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
    /* Thiết lập cột cho sản phẩm */
    .product-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); /* Tự động tạo cột */
        gap: 15px;
        max-height: 400px;
        overflow-y: auto;
    }
    .product-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        background-color: #fff;
        text-align: center;
    }
    .product-item img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        margin-bottom: 10px;
    }

    /* Tìm kiếm */
    .search-container {
        margin-bottom: 10px;
    }
</style>

<h1>Form Create Topping</h1>
<form action="{{ route('topping.update', $topping->id) }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Nội dung form -->
    <div class="col-md">
        <div class="form-group">
            <label for="">Tên</label>
            <input type="text" class="form-control" name="name" value="{{ $topping->name }}" placeholder="Input Name">
        </div>

        <div class="form-group">
            <label for="">Ảnh</label>
            <input type="hidden" name="currentImage" value="{{ $topping->image }}">
            <img src="/topping_img/{{ $topping->image }}" id="image_preview" name="imagePreview" alt="Ảnh Topping">
            <div>
                <input type="file" id="image" name="newImage" accept="image/*">
            </div>
        </div>

        <div class="form-group">
            <label for="">Giá</label>
            <input type="number" class="form-control" name="price" value="{{ $topping->price }}" placeholder="Input price">
        </div>

        <div class="form-group">
            <label for="">Loại</label>
            <select name="type" id="type" class="form-control" required="required">
                <option value="0" {{ $topping->type == 0 ? 'selected' : ''}}>Topping riêng</option>
                <option value="1" {{ $topping->type == 1 ? 'selected' : ''}}>Topping kèm sản phẩm</option>
            </select>
        </div>

        <!-- Trường chọn sản phẩm liên kết với nhiều lựa chọn -->
        <div class="form-group" id="product_select_group" style="{{ $topping->type == 1 ? '' : 'display:none'}}">
            <label for="">Sản phẩm được đính kèm</label>
            
            <!-- Ô tìm kiếm sản phẩm -->
            <div class="search-container">
                <input type="text" id="product_search" class="form-control" placeholder="Tìm sản phẩm được đính kèm...">
            </div>
            
            <!-- Danh sách sản phẩm -->
            <div id="product_list" class="product-list">
                @foreach($products as $product)
                    <div class="product-item">
                        <label>
                            <input type="checkbox" 
                            class="product-checkbox" 
                            name="products[]" 
                            value="{{ $product->id }}">
                            <img src="/product_img/{{ $product->pro_number }}/{{ $product->thumbnail }}" alt="{{ $product->name }}">
                            <div class="productName">{{ $product->name }}</div>
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="form-group">
            <label for="">Trạng Thái</label>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="1" {{ $topping->status == 1 ? 'checked' : ''}}>
                    Hiển thị
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="0" {{ $topping->status == 0 ? 'checked' : ''}}>
                    Ẩn
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </div>
</form>

<script>
    const linkedProductIds = @json($linkedProductIds);

    $(document).ready(function() {
        $('.product-checkbox').each(function() {
            // Chuyển `checkbox.value` thành integer và kiểm tra nếu có trong linkedProductIds
            if (linkedProductIds.includes(parseInt($(this).val()))) {
                $(this).prop('checked', true);
            }
        });

        // Hiển thị thumbnail
        $('#image').change(function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#image_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        });

        // Hiển thị/ẩn trường chọn sản phẩm khi thay đổi loại topping
        $('#type').change(function() {
            var type = $(this).val();
            if (type == '1') {
                // Nếu là topping kèm sản phẩm, hiển thị trường chọn sản phẩm
                $('#product_select_group').show();
            } else {
                // Nếu là topping riêng, ẩn trường chọn sản phẩm
                $('#product_select_group').hide();
            }
        });

        // Tìm kiếm sản phẩm
        $('#product_search').keyup(function() {
            var searchQuery = $(this).val().toLowerCase();
            $('.product-item').each(function() {
                var productName = $(this).find('.productName').text().toLowerCase();
                if (productName.includes(searchQuery)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Mảng để lưu trữ các ID sản phẩm được chọn
        let selectedProducts = [];

        // Xử lý khi checkbox thay đổi (check/uncheck)
        $('.product-checkbox').change(function() {
            const productId = $(this).val();  // Lấy ID của sản phẩm

            if ($(this).prop('checked')) {
                // Nếu checkbox được chọn, thêm ID vào mảng
                selectedProducts.push(productId);
            } else {
                // Nếu checkbox bị bỏ chọn, xóa ID khỏi mảng
                const index = selectedProducts.indexOf(productId);
                if (index > -1) {
                    selectedProducts.splice(index, 1);
                }
            }

            console.log('Sản phẩm được chọn: ', selectedProducts);  // In mảng ra console để kiểm tra
        });
    });
</script>

@stop
