@extends('front.general')
@section('main')

<style>
    /* Giới hạn hiển thị mô tả trong 1 dòng */
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

    /* Hiệu ứng hover */
    .product-container:hover {
        box-shadow: 0 4px 8px rgba(88, 235, 132, 0.2);
        background-color: #f9f9f9;
    }

    .product-img {
        height: 150px;
        width: 100%;
        object-fit: cover;
    }

    /* Định dạng khoảng cách và kích thước của nút */
    .btn-product {
        margin-top: 10px;
    }

    /* Nhỏ hơn nút "Chi tiết" và canh trái */
    .btn-detail {
        font-size: 14px;
        padding: 6px 12px;
        width: auto;
    }

    .favorite-btn {
        font-size: 30px;
        padding: 6px 12px;
        color: #4b4444;
        background-color: transparent;
        border: none;
    }

    .favorite-btn:hover {
        color: #e74c3c;
    }

    .heart-icon.active {
        color: red; 
    }

    .btn-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }
</style>

<div class="container">
    <h1 class="text-center">Tất cả toppings</h1>

    <!-- Row chứa danh sách sản phẩm -->
    <div class="row">
        @if (!count($toppings))
            <h2>Chưa có sản phẩm nào.</h2>
        @else
            @foreach ($toppings as $topping)
                <div class="col-sm-4 product-container">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <!-- Product Image -->
                            <img src="/topping_img/{{ $topping->image }}" alt="{{ $topping->name }}" class="img-responsive product-img">
                            <!-- Product Info -->
                            <h3>{{ $topping->name }}</h3>
                            <p><strong>Price:</strong> {{ formatPrice($topping->price) }} VNĐ</p>
                            <!-- Add to Cart Button -->
                            <a href="{{ route('front.cart.addTopping', $topping->id) }}" class="btn btn-success btn-block btn-product">Thêm vào giỏ hàng</a>
                            <a href="{{ route('front.topping.detail', $topping->id) }}" class="btn btn-primary btn-block btn-detail">Chi tiết</a>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

@stop
