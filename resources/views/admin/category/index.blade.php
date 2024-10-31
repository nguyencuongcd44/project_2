@extends('admin.general')
@section('main')

<h1>Danh Mục</h1>
<a href="{{ route('category.create')}}" class="btn btn-success">Thêm Mới</a>
<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($cats as $cat)
        <tr>
            <td>{{ $cat->id}}</td>

            <td>{{ $cat->name}}</td>

            <td>{{ $cat->status == 0 ? 'Tạm Ẩn' : 'Hiển Thị'}}</td>

            <td>
                <form id="deleteForm{{$cat->id}}" action="{{ route('category.destroy', $cat->id) }}" method="POST" role="form">
                    @csrf @method('DELETE')
                    <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <button type="submit" onclick="formDeleteConfirm('{{ $cat->id }}')" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

{{ $cats->links() }}

@stop