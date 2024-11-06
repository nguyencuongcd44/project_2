@extends('front.general')
@section('main')

<style>
    .btn:hover {
        opacity: 0.9;
    }

    .front.favorite-container {
        margin-top: 50px;
    }

    .front.favorite-buttons {
        margin-top: 20px;
    }

    .table > tbody > tr > td {
        vertical-align: middle;
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
</style>

<div class="container front.favorite-container">
    <h1 class="text-center">Danh sách yêu thích của bạn</h1>

    @if (!count($favoriteItems))
        <div class="alert alert-info text-center" style="width: 100%;">
            <strong>Bạn chưa có sản phẩm nào trong danh sách yêu thích.</strong>
        </div>
        
        <div class="text-center">
            <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại mua sắm</a>
        </div>
    @else
         <!-- Table hiển thị danh sách sản phẩm trong danh sách yêu thích -->
         <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Ảnh đại diện</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($favoriteItems as $item)
                    <tr>
                        <!-- Tên sản phẩm -->
                        <td style="width: 25%;">
                            <a href="{{ route('front.product', $item->id) }}">{{ $item->name }}</a>
                        </td>

                        <!-- Hiển thị ảnh sản phẩm -->
                        <td style="width: 15%;">
                            <img src="/images/{{ $item->image }}" alt="{{ $item->name }}" class="img-responsive product-img">
                        </td>

                        <!-- Mô tả sản phẩm -->
                        <td style="width: 35%;">{{ $item->contents }}</td>

                        <!-- Giá sản phẩm -->
                        <td style="width: 15%;">{{ formatPrice($item->price) }} VNĐ</td>
        
                        <!-- Nút Remove -->
                        <td style="width: 10%;">
                            <button type="button" class="btn btn-danger favorite-action" data-action="delete" data-id="{{ $item->id }}">Xóa</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Nút điều khiển -->
        <div class="front.favorite-buttons text-center">
            <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại mua sắm</a>
            <button class="btn btn-danger favorite-action" data-action="clear">Xóa tất cả khỏi danh sách yêu thích</button>
        </div>
    @endif
</div>

<script>
    $(document).ready(function(){
        $('.favorite-action').click(function() {
            var $heartIcon = $(this).find('.heart-icon');
            var action = $(this).data('action');
            var productId = '';
            if(action == 'delete'){
                productId = $(this).data('id');
            }
            
            defaultSwal.fire({
                title: 'Xác Nhận',
                text: "Bạn có chắc chắn muốn xóa!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Quay Lại'

            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/favorite/' + action, 
                        method: 'POST',
                        data: {
                            id: productId,
                            _token: '{{ csrf_token() }}' 
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                }
            });
            
        });
    });
</script>
@stop
