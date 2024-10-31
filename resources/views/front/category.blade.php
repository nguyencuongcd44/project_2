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
            </tr>
        </thead>

        <tbody>
            @foreach($products as $product)
            <tr>
                <!-- Cột ID -->
                <td>{{ $product->id }}</td>

                <!-- Cột Tên sản phẩm -->
                <td>{{ $product->name }}</td>

                <!-- Cột Ảnh sản phẩm -->
                <td>
                    <img src="/images/{{ $product->image }}" alt="{{ $product->name }}" class="img-responsive" style="max-width: 100px; height: auto;">
                </td>

                <!-- Cột Giá sản phẩm -->
                <td>{{ number_format($product->price, 0, ',', '.') }} VNĐ</td>

                <!-- Cột Mô tả (giới hạn số lượng hiển thị) -->
                <td>{{ Str::limit($product->contents, 50, '...') }}</td>

                <!-- Cột Chi tiết và thêm vào giỏ hàng -->
                <td style="display: flex; align-items: center;">
                    <!-- Link đến chi tiết sản phẩm -->
                    <div class="btn-block text-center">
                        <a href="{{ route('front.product', $product->id) }}" class="btn btn-primary">Chi Tiết</a>
                    </div>

                    <!-- Ô nhập số lượng và thêm vào giỏ hàng -->
                    <div class="text-center" style="margin-top: 10px;">
                        <input type="number" name="quantity" value="1" class="form-control text-center" min="1" style="width: 100%; margin: 10px auto;">
                        <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success btn-block" type="button">Thêm vào giỏ hàng</a>
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