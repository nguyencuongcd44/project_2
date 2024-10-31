@extends('admin.general')
@section('main')

<h1>Form Create Category</h1>

<form action="{{ route('category.store') }}" method="POST" role="form">
    @csrf
    <div class="col-md">
        <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" name="name" placeholder="Input Name">
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


@stop