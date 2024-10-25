@extends('front.general')
@section('main')

<style>
    .img-tag{
        display: flex;
        justify-content: center;
        align-items: center;

        .product-img {
            height: 300px;
            width: auto;
            object-fit: cover;
        }
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
                    @if($product->image)
                        <div class="img-tag">
                            <img src="/images/{{ $product->image }}" alt="{{ $product->name}}" class="img-responsive product-img" style="max-width: 100%; height: auto;">
                        </div>
                    @else
                        <p>Không có ảnh sản phẩm</p>
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
                        <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VNĐ</p>
                        <p><strong>Miêu tả:</strong> {{ $product->contents }}</p>
                    </div>
                    <hr>
                    <!-- Thêm vào giỏ hàng (luôn nằm dưới cùng) -->
                    <form action="{{ route('cart.add', $product->id) }}" method="get">
                        <div class="input-group">
                            <input type="number" name="quantity" value="1" class="form-control text-center" min="1" style="max-width: 100px;">
                            <span class="input-group-btn">
                                <button type= "submit" class="btn btn-success" type="button">Thêm vào giỏ hàng</button>
                            </span>
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
                                    <p>{{ $comment->text }}</p>
                                </div>
                                @auth('cus')
                                    @if(auth()->guard('cus')->user()->can('my-comment', $comment))
                                        <div class="panel-footer text-right">
                                            <button class="btn btn-primary btn-sm">Edit</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
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

@stop