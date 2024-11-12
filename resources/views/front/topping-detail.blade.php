@extends('front.general')
@section('main')

<style>
    .preview-image{
        display: flex;
        justify-content: center;
        align-items: center;
        
        .slick-slide{
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .preview{
            max-width: 400px; 
            width: 100%;
            object-fit: contain; 
        }

        .slick-next{
            z-index: 1;
            right: 0px;
            width: 40px;
            height: 40px;
        }
        .slick-next::before {
            color: #449d44;
            font-size: 40px;

        }

        .slick-prev{
            z-index: 1;
            left: 0px;
            width: 40px;
            height: 40px;
        }
        .slick-prev::before {
            color: #449d44;
            font-size: 40px;
        }
    }

    .detail-image-nav{
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        
        .slick-list{
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .slick-track{
            width: 100%;
            display: flex;
            /* transform: none !important; */
            gap: 10px;
        }

        .slick-slide{
            width: 75px;
            height: 75px;
            border: 1.5px solid rgba(109, 109, 109, 0.541);
            border-radius: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0.3;
            transition: opacity 0.3s;
            object-fit: cover;
            overflow: hidden;
        }

        .slick-current {
            opacity: 1; 
        }

        .nav-images{
            width: 100%; 
            height: auto; 
            object-fit: cover; 
        }
    }
    
    .detail-actions{
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    .heart-icon.active {
        color: red; 
    }
    .favorite-btn:hover {
        color: #e74c3c;
    }

</style>

<div class="container">
    <h2 class="text-center">Chi tiết topping</h2>
    <div class="row">
        <!-- Hình ảnh sản phẩm bên trái -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <!-- Hiển thị ảnh sản phẩm -->
                    @if ($topping->image)
                        <div class="preview-image">
                            <img class="preview" src="/topping_img/{{ $topping->image }}" alt="{{ $topping->name }}">
                        </div>
                    @else
                        <p>Không có ảnh chi tiết.</p>
                    @endif
                    
                </div>
            </div>
        </div>

        <!-- Thông tin sản phẩm bên phải, cùng chiều cao với khu vực ảnh -->
        <div class="col-md-6">
            <div class="panel panel-default" style="height: 100%;">
                <div class="panel-body d-flex flex-column" style="height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                    <div>
                        <h3>{{ $topping->name }}</h3>
                        <p><strong>Giá:</strong> {{ formatPrice($topping->price) }} VNĐ</p>
                    </div>
                    <hr>
                    <!-- Thêm vào giỏ hàng (luôn nằm dưới cùng) -->
                    <form action="{{ route('cart.addTopping', $topping->id) }}" method="get">
                        <div class="input-group detail-actions">
                            <input type="number" name="quantity" value="1" class="form-control text-center" min="1" style="max-width: 100px;">
                            <button type= "submit" class="btn btn-success" type="button">Thêm vào giỏ hàng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Nút quay lại -->
    <div class="text-center">
        <a href="{{ route('front.toppings') }}" class="btn btn-primary">Quay lại danh sách toppings</a>
    </div>
</div>
@stop