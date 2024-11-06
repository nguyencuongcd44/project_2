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
            <th>Thumbnail</th>
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
                <img src="/product_img/{{ $product->thumbnail }}" alt="{{ $product->name}}"></img>
            </td>

            <td>{{ formatPrice($product->price)}} VND</td>

            <td>{{ $product->contents}}</td>

            <td>{{ $product->category->name}}</td>

            <td>{{ $product->status == 0 ? 'Tạm Ẩn' : 'Hiển Thị'}}</td>

            <td>
                <form id="deleteForm{{$product->id}}" action="{{ route('product.destroy', $product->id) }}" method="POST" role="form">
                    @csrf @method('DELETE')
                    <a href="{{ route('product.edit', $product->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <button onclick="formDeleteConfirm('{{ $product->id }}')" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@stop