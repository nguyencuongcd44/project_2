@extends('admin.general')
@section('main')

<style>
    img{
        max-width: 200px;
        height: auto;
    }
</style>
<h1>Sản Phẩm</h1>
<a href="{{ route('product.create')}}" class="btn btn-success">Thêm Mới</a>
<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Ảnh</th>
            <th>Giá (vnd)</th>
            <th>Miêu tả</th>
            <th>Danh mục</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id}}</td>

            <td>{{ $product->name}}</td>

            <td>
                <img src="/images/{{ $product->image }}" alt="{{ $product->name}}"></img>
            </td>

            <td>{{ $product->price}}</td>

            <td>{{ $product->contents}}</td>

            <td>{{ $product->category->name}}</td>

            <td>{{ $product->status == 0 ? 'Tạm Ẩn' : 'Hiển Thị'}}</td>

            <td>
                <form action="{{ route('product.destroy', $product->id) }}" method="POST" role="form">
                    @csrf @method('DELETE')
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <button class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@stop