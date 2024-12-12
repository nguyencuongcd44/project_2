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
    <h2 class="text-center">Chi tiết sản phẩm</h2>
    <div class="row">
        <!-- Hình ảnh sản phẩm bên trái -->
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body text-center">
                    <!-- Hiển thị ảnh sản phẩm -->
                    @if (count($imgs))
                        <div class="preview-image">
                            @foreach ($imgs as $img)
                                <div><img class="preview" src="/product_img/{{ $product->pro_number }}/{{ $img }}" alt="{{ $product->name }}"></div>
                            @endforeach
                        </div>
                        <hr>
                        <div class="detail-image-nav">
                            @foreach ($imgs as $img)
                                <div><img class="nav-images" src="/product_img/{{ $product->pro_number }}/{{ $img }}" alt="{{ $product->name }}"></div>
                            @endforeach
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
                        <h3>{{ $product->name }}</h3>
                        <p><strong>Giá:</strong> {{ formatPrice($product->price) }} VNĐ</p>
                        <p><strong>Miêu tả:</strong> {{ $product->contents }}</p>
                    </div>
                    <hr>
                    <!-- Thêm vào giỏ hàng (luôn nằm dưới cùng) -->
                    <form action="{{ route('cart.addProduct', $product->id) }}" method="get">
                        <div class="input-group detail-actions">
                            <input type="number" name="quantity" value="1" class="form-control text-center" min="1" style="max-width: 100px;">
                            <span class="input-group-btn">
                                <button type= "submit" class="btn btn-success" type="button">Thêm vào giỏ hàng</button>
                            </span>
                            <button type="button" class="btn favorite-btn" data-id="{{ $product->id }}">
                                <span class="heart-icon {{ in_array($product->id, $favoriteList) ? 'active' : '' }}">&#10084;</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Khu vực bình luận nằm dưới thông tin sản phẩm -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (Auth::guard('cus')->check())
                        <h3>Để lại bình luận của bạn</h3>
                        <form method="post" action="{{ route('front.post_cmt', $product->id) }}" role="form">
                            @csrf
                            <textarea name="comment" id="comment" rows="4" style="width: 100%; padding: 10px;" class="form-control" placeholder="Viết bình luận của bạn..."></textarea>
                            <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Gửi bình luận</button> <!-- Cách ra nút gửi bình luận -->
                        </form>
                    @else
                        <div class="alert alert-danger">
                            <strong>Đăng nhập để bình luận</strong> 
                            <a href="{{ route('account.login') }}" class="btn btn-primary">Đăng Nhập</a>
                        </div>
                    @endif

                    <!-- Hiển thị bình luận -->
                    @if (!count($comments))
                        <h3>Chưa có bình luận nào.</h3>
                    @else
                        <hr>
                        
                        @foreach ($comments as $comment)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4>{{ $comment->customer->name }} <small class="text-muted">{{ $comment->created_at->format('Y/m/d') }}</small></h4>
                                </div>
                                <div class="panel-body">
                                    <p id="commentText{{$comment->id}}">{!! nl2br($comment->text) !!}</p>
                                </div>
                                @auth('cus')
                                    @if(auth()->guard('cus')->user()->can('my-comment', $comment))
                                        <div class="panel-footer text-right">
                                            <button onclick="updateComment('{{ route('front.update_cmt', $comment->id) }}', '{{ $comment->id }}')" class="btn btn-primary btn-sm">Edit</button>
                                            <button onclick="deleteConfirm('{{ route('front.delete_cmt', $comment->id) }}')" class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    @endcan
                                @endauth
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Nút quay lại -->
    <div class="text-center">
        <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại danh sách sản phẩm</a>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('.preview-image').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            asNavFor: '.detail-image-nav',
            adaptiveHeight: false,
            infinite: false,
        });

        $('.detail-image-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            // asNavFor: '.preview-image',
            dots: false, 
            focusOnSelect: true,
            infinite: false,
        });
    });

</script>
@stop