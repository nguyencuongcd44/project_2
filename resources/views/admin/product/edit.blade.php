@extends('admin.general')
@section('main')

<style>
    #image_preview{
        max-width: 100%;
        padding: 10px 0 10px 0;
    }
</style>

<h1>Form Chỉnh sửa sản phẩm</h1>
<form action="{{ route('product.update', $product->id) }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    @method('PUT') <!-- Sử dụng phương thức PUT để cập nhật -->

    <!-- lỗi -->
    @if($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
            <hr>
        </div>
    @endif

    <!-- nội dung form -->
    <div class="col-md">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $product->name }}" placeholder="Input Name">
        </div>

        <div class="form-group">
            <label for="">Ảnh</label>
            <img src="/images/{{ $product->image }}" alt="{{ $product->name}}" id="image_preview">
            <input type="hidden" value="/images/{{ $product->image }}" id="image" name="image">
            <div>
                <input type="file" id="img_upload" name="img_upload">
            </div>
        </div>

        <div class="form-group">
            <label for="">Giá</label>
            <input type="number" class="form-control" name="price" value="{{ $product->price }}" placeholder="Input price">
        </div>

        <div class="form-group">
            <label for="">Miêu Tả</label>
            <textarea class="form-control" rows="8" name="contents" value="{{ $product->contents }}" placeholder="Input Content">{{ $product->contents }}</textarea>
        </div>

        <div class="form-group">
            <label for="">Danh Mục</label>

            <select name="category_id" id="category" class="form-control" required="required">
                @foreach($cats as $cat)
                    <option value="{{$cat->id}}" {{ $product->category_id == $cat->id ? 'selected' : ''}}>{{ $cat->name }}</option>
                @endforeach
            </select>
            
        </div>

        <div class="form-group">
            <label for="">Trạng Thái</label>

            <div class="radio">
                <label>
                    <input type="radio" name="status" value="1" {{$product->status == 0 ? 'checked' : ''}}>
                    Hiển thị
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="status" value="0" {{$product->status == 1 ? 'checked' : ''}}>
                    Ẩn
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Thêm</button>
        </div>
    </div>
</form>


<script>
    $(document).ready(function(){
        $('#img_upload').change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
          
            reader.onload = (function(file) {
                return function(e) {
                    $('#image_preview').attr('src', e.target.result);
                    $('#image').attr('value', file.name);
                    $('#img_upload').attr('data-name', file.name);
                };
            })(file);
            reader.readAsDataURL(file);
        });
    });
    
</script>


@stop