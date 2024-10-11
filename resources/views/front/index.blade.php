@extends('front.general')
@section('main')

<style>
    /* Giới hạn hiển thị mô tả trong 2 dòng */
    .product-description {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    /* Định dạng sản phẩm */
    .product-container {
        margin-bottom: 30px;
        transition: all 0.3s ease;
    }

    /* Hiệu ứng hover: thêm đổ bóng và thay đổi màu nền */
    .product-container:hover {
        box-shadow: 0 4px 8px rgba(88, 235, 132, 0.2);
        background-color: #f9f9f9;
    }

    .product-img {
        height: 150px;
        width: 100%;
        object-fit: cover;
    }

    /* Khoảng cách giữa các nút */
    .btn-product {
        margin-top: 10px;
    }
</style>
<div class="container">
    <h1 class="text-center">All Products</h1>

    <!-- Row chứa danh sách sản phẩm -->
    <div class="row">
        <!-- Product 1 -->
        @if (!count($products))
            <h2>Chưa có sản phẩm nào.</h2>
        @else
            @foreach ($products as $product)
                <div class="col-sm-4 product-container">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <!-- Product Image -->
                            <img src="/images/{{ $product->image }}" alt="{{ $product->name}}" class="img-responsive product-img">
                            <!-- Product Info -->
                            <h3>{{ $product->name }}</h3>
                            <p><strong>Category:</strong> {{ $product->category->name }}</p>
                            <p><strong>Price:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ VNĐ</p>
                            <p class="product-description">{{ $product->contents }}</p>
                            <!-- Add to Cart and View Detail Buttons -->
                            <a href="{{ route('cart.add', $product->id) }}" class="btn btn-success btn-block btn-product">Thêm vào giỏ hàng</a>
                            <a href="{{ route('front.product', $product->id) }}" class="btn btn-primary btn-block btn-product">Chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $products->links() }}
        @endif
        <!-- Thêm các sản phẩm khác theo mẫu trên -->
    </div>
</div>

@stop