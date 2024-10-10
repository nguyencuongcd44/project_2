@extends('admin.general')
@section('main')

<style>
    #image_preview{
        max-width: 100%;
        padding: 10px 0 10px 0;
    }
</style>

<h1>Form Create Product</h1>
<form action="{{ route('product.store') }}" method="POST" role="form" enctype="multipart/form-data">
    @csrf
    <!-- lỗi -->
    @if($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p class="text-danger">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- nội dung form -->
    <div class="col-md">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Input Name">
        </div>

        <div class="form-group">
            <label for="">Ảnh</label>
            <img id="image_preview" name="image">
            <div>
                <input type="file" id="img_upload" name="img_upload">
            </div>
        </div>

        <div class="form-group">
            <label for="">Giá</label>
            <input type="number" class="form-control" name="price" value="{{ old('price') }}" placeholder="Input price">
        </div>

        <div class="form-group">
            <label for="">Miêu Tả</label>
            <textarea class="form-control" rows="8" name="contents" value="{{ old('contents') }}" placeholder="Input Content">{{ old('contents') }}</textarea>
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
</form>


<script>
    $(document).ready(function(){
        $('#img_upload').change(function(e) {
            var file = e.target.files[0];
            var reader = new FileReader();
          
            reader.onload = (function(file) {
                return function(e) {
                    $('#image_preview').attr('src', e.target.result);
                    $('#img_upload').attr('data-name', file.name);
                };
            })(file);
            reader.readAsDataURL(file);
        });
    });
    
</script>


@stop