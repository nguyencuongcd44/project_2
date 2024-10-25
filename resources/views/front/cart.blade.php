@extends('front.general')
@section('main')

<style>
    /* Hiệu ứng hover cho các nút */
    .btn:hover {
        opacity: 0.9;
    }

    /* Tạo padding và khoảng cách */
    .cart-container {
        margin-top: 50px;
    }

    /* Tổng tiền và các nút phía dưới */
    .cart-summary {
        font-size: 18px;
        font-weight: bold;
    }

    .total-price {
        color: #d9534f;
    }

    /* Khoảng cách giữa các nút */
    .cart-buttons {
        margin-top: 20px;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
    }

    .cart-item-quantity {
        width: 80px;
    }
</style>
<div class="container cart-container">
    <h1 class="text-center">Giỏ hàng của bạn</h1>

    @if (!count($cart->cartItems))
        <div class="alert alert-info text-center" style="width: 100%;">
            <strong>Chưa có sản phẩm nào. Vui lòng mua hàng</strong>
        </div>
        
        <div class="text-center">
            <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại mua sắm</a>
        </div>
    @else
         <!-- Table hiển thị danh sách sản phẩm trong giỏ hàng -->
         <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cart->cartItems as $item)
                    <tr>
                        <!-- Tên sản phẩm -->
                        <td style="width: 25%;">
                            <a href="{{ route('front.product', $item->id) }}">{{ $item->name }}</a>
                        </td>

                        <!-- Hiển thị ảnh sản phẩm -->
                        <td style="width: 15%;">
                            <img src="/images/{{ $item->image }}" alt="{{ $item->name}}" class="img-responsive product-img">
                        </td>

                        <!-- Giá sản phẩm -->
                        <td style="width: 15%;">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>

                        <!-- Số lượng và nút Update căn ngang hàng -->
                        <td style="width: 15%;">
                            <form action="{{ route('cart.update', $item->id) }}" method="get">
                                @csrf
                                <div class="input-group">
                                    <input type="number" class="form-control cart-item-quantity text-center" name="quantity" value="{{ $item->quantity }}" min="1">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary btn-sm" type="button">Update</button>
                                    </span>
                                </div>
                            </form>
                        </td>
        
                        <!-- Thành tiền -->
                        <td style="width: 20%;">{{ $item->price * $item->quantity }} VNĐ</td>
        
                        <!-- Nút Remove -->
                        <td style="width: 10%;">
                            <a onclick="deleteConfirm('{{ route('cart.delete', $item->id) }}')" href="{{ route('cart.delete', $item->id) }}" class="btn btn-danger btn-sm">Xóa</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Tổng giá và các nút điều khiển -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="cart-buttons">
                    <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại mua sắm</a>
                    <a href="{{ route('cart.clear') }}" onclick="deleteConfirm('{{ route('cart.clear') }}')" class="btn btn-danger">Xóa giỏ hàng</a>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <p class="cart-summary">Tổng số tiền: <span class="total-price">{{ number_format($cart->totalPrice, 0, ',', '.') }} VNĐ</span></p>
                <button class="btn btn-success">Thanh toán</button>
            </div>
        </div>
    @endif
</div>


@stop