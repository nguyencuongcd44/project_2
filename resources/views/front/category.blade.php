@extends('front.general')
@section('main')

<style>
    img{
        max-width: 200px;
        height: auto;
    }
    .table>tbody>tr>td, 
    .table>tbody>tr>th, 
    .table>tfoot>tr>td, 
    .table>tfoot>tr>th, 
    .table>thead>tr>td, 
    .table>thead>tr>th {
        vertical-align: middle;
    }
    
    .favorite-btn{
        background-color: unset;
        padding: 0;

        .heart-icon{
            display: inline-block;
            padding: 0;
            font-size: 40px;
        }
    }
    .heart-icon:focus-visible {
        outline: unset;
    }
    .favorite-btn:hover {
        color: #e74c3c;
    }
    .heart-icon.active {
        color: red; 
    }
</style>
<div class="container">
    <h1 class="text-center">Sản Phẩm thuộc {{ $category->name }}</h1>
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
                <th></th>
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>

                <td>{{ $product->name }}</td>

                <td>
                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}" class="img-responsive" style="max-width: 100px; height: auto;">
                </td>

                <td>{{ formatPrice($product->price) }} VNĐ</td>

                <td>{{ Str::limit($product->contents, 50, '...') }}</td>

                <td style="display:flex; flex-direction:column; align-items:center">
                    <div class="btn-block text-center">
                        <a href="{{ route('front.product', $product->id) }}" class="btn btn-primary">Chi Tiết</a>
                    </div>
                    <button type="button" class="btn favorite-btn" data-id="{{ $product->id }}">
                        <span class="heart-icon {{ in_array($product->id, $favoriteList) ? 'active' : '' }}">&#10084;</span>
                    </button>
                </td>

                <td style="">
                    <div class="text-center" style="margin-top: 10px;">
                        <form action="{{ route('cart.addProduct', $product->id) }}" method="get">
                            @csrf
                            <input type="number" name="quantity" value="1" class="form-control text-center" min="1" style="width: 100%; margin: 10px auto;">
                            <button class="btn btn-success btn-block" type="submit">Thêm vào giỏ hàng</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Phân trang -->
    <div class="text-center">
        {{ $products->links() }}
    </div>
</div>

@stop