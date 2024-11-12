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

    @if ($cart->totalQuantity == 0 && $cart->totalPrice == 0)
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
                @if (count($cart->cartItems['products']))
                    <td colspan="6"><strong>Sản phẩm</strong></td>
                    @foreach ($cart->cartItems['products'] as $product)
                        <tr>
                            <!-- Tên sản phẩm -->
                            <td style="width: 25%;">
                                <a href="{{ route('front.product', $product->id) }}">{{ $product->name }}</a>
                            </td>

                            <!-- Hiển thị ảnh sản phẩm -->
                            <td style="width: 15%;">
                                <img src="/product_img/{{ $product->pro_number }}/{{ $product->thumbnail }}" alt="{{ $product->name}}" class="img-responsive product-img">
                            </td>

                            <!-- Giá sản phẩm -->
                            <td style="width: 15%;">{{ formatPrice($product->price) }} VNĐ</td>

                            <!-- Số lượng và nút Update căn ngang hàng -->
                            <td style="width: 15%;">
                                <form action="{{ route('cart.updateProduct', $product->id) }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" class="form-control cart-item-quantity text-center" name="quantity" value="{{ $product->quantity }}" min="1">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-sm" type="button">Update</button>
                                        </span>
                                    </div>
                                </form>
                            </td>
            
                            <!-- Thành tiền -->
                            <td style="width: 20%;">{{ formatPrice($product->price * $product->quantity) }} VNĐ</td>
            
                            <!-- Nút Remove -->
                            <td style="width: 10%;">
                                <button onclick="deleteConfirm('{{ route('cart.deleteProduct', $product->id) }}')" class="btn btn-danger btn-sm">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                @endif

                @if (count($cart->cartItems['toppings']))
                    <td colspan="6"><strong>Topping</strong></td>
                    @foreach ($cart->cartItems['toppings'] as $topping)
                        <tr>
                            <!-- Tên sản phẩm -->
                            <td style="width: 25%;">
                                <a href="{{ route('front.topping.detail', $topping->id) }}">{{ $topping->name }}</a>
                            </td>

                            <!-- Hiển thị ảnh sản phẩm -->
                            <td style="width: 15%;">
                                <img src="/topping_img/{{ $topping->image }}" alt="{{ $topping->name}}" class="img-responsive product-img">
                            </td>

                            <!-- Giá sản phẩm -->
                            <td style="width: 15%;">{{ formatPrice($topping->price) }} VNĐ</td>

                            <!-- Số lượng và nút Update căn ngang hàng -->
                            <td style="width: 15%;">
                                <form action="{{ route('cart.updateTopping', $topping->id) }}" method="get">
                                    @csrf
                                    <div class="input-group">
                                        <input type="number" class="form-control cart-item-quantity text-center" name="quantity" value="{{ $topping->quantity }}" min="1">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-sm" type="button">Update</button>
                                        </span>
                                    </div>
                                </form>
                            </td>
            
                            <!-- Thành tiền -->
                            <td style="width: 20%;">{{ formatPrice($topping->price * $topping->quantity) }} VNĐ</td>
            
                            <!-- Nút Remove -->
                            <td style="width: 10%;">
                                <button onclick="deleteConfirm('{{ route('cart.deleteTopping', $topping->id) }}')" class="btn btn-danger btn-sm">Xóa</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
                
            </tbody>
        </table>

        <!-- Tổng giá và các nút điều khiển -->
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="cart-buttons">
                    <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại mua sắm</a>
                    <button onclick="deleteConfirm('{{ route('cart.clear') }}')" class="btn btn-danger">Xóa giỏ hàng</button>
                </div>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <p class="cart-summary">Tổng số tiền: <span class="total-price">{{ formatPrice($cart->totalPrice) }} VNĐ</span></p>
                <a href="{{ route('front.payment.method') }}" class="btn btn-success">Thanh toán</a>
            </div>
        </div>
    @endif
</div>


@stop