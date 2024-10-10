@extends('admin.general')
@section('main')

<h1>Form Chỉnh Sửa Danh Mục</h1>

<form action="{{ route('category.update', $category->id) }}" method="POST" role="form">
<!-- update luôn sử dụng phương thức PUT -->
    @csrf @method('PUT') 

    <div class="col-md">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="Input Name">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group">
            <label for="">Trạng Thái</label>
            
            <div class="radio">
                <label>
                    <input type="radio" name="status" value="1" {{$category->status == 1 ? 'checked' : ''}}>
                    Hiển thị
                </label>
            </div>

            <div class="radio">
                <label>
                    <input type="radio" name="status" value="0" {{$category->status == 0 ? 'checked' : ''}}>
                    Ẩn
                </label>
            </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>


@stop