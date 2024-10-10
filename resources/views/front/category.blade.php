@extends('front.general')
@section('main')

<style>
    img{
        max-width: 200px;
        height: auto;
    }
</style>
<h1>Sản Phẩm thuộc {{ $category->name }}</h1>
<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Ảnh</th>
            <th>Giá (vnd)</th>
            <th>Miêu tả</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->id}}</td>

            <td>{{ $product->name}}</td>

            <td>
                <img src="/images/{{ $product->image }}" alt="{{ $product->name}}">
            </td>

            <td>{{ $product->price}}</td>

            <td>{{ $product->contents}}</td>

            <td><a href="{{ route('front.product', $product->id)}}" class="btn btn-link btn-block">Chi Tiết</a></td>
        </tr>

        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@stop