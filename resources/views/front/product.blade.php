@extends('front.general')
@section('main')

<div class="container">
    <h2 class="text-center">Chi tiết sản phẩm</h2>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sản phẩm: {{ $product->name }}</h3>
                </div>
                <div class="panel-body">
                    <!-- Hiển thị ảnh sản phẩm -->
                    @if($product->image)
                        <img src="/images/{{ $product->image }}" alt="{{ $product->name}}" class="img-responsive" style="width:100%; height:auto;">
                    @else
                        <p>Không có ảnh sản phẩm</p>
                    @endif

                    <p><strong>ID sản phẩm:</strong> {{ $product->id }}</p>
                    <p><strong>Tên sản phẩm:</strong> {{ $product->name }}</p>
                    <p><strong>Giá:</strong> {{ number_format($product->price, 0, ',', '.') }} VND</p>
                    <p><strong>Miêu tả:</strong> {{ $product->description }}</p>
                    <hr>
                    @if (Auth::check())
                        <div>
                            <h3>Bình Luận</h3>
                            <form method="post" action="{{ route('front.post_cmt', $product->id) }}" role="form">
                                @csrf
                                <textarea name="comment" id="comment" cols="" rows="4" style="width: 100%; padding: 10px;"></textarea>
                                @if ($errors -> has('comment'))
                                    <small class="text-danger">{{ $errors->first('comment')}}</small>
                                @endif
                                <button type="submit" class="btn btn-primary">Bình Luận</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <strong>Đăng nhập để bình luận</strong> 
                            <a href="{{ route('login') }}" class="btn btn-primary">Đăng Nhập</a>
                        </div>
                    @endif
                    
                    @if (!count($comments))
                        <h3>Chưa có bình luận nào.</h3>

                    @else
                        <hr>
                        <div class="">
                            @foreach ($comments as $comment)
                                <div class="panel panel-default">
                                    <div class="panel">
                                        <h4 class="p-l-10">{{ $comment->user->name }} <small class="text-muted">{{ $comment->created_at }}</small></h4>
                                    </div>
                                    <div class="panel-body">
                                        {{ $comment->text }}
                                    </div>
                                    @if (Auth::check() && Auth::User()->id == $comment->user->id)
                                        <div class="text-right">
                                            <button class="btn btn-primary btn-sm">Edit</button>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    @endif
                                   
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="panel-footer text-center">
                    <a href="{{ route('home.index') }}" class="btn btn-primary">Quay lại danh sách sản phẩm</a>
                </div>
            </div>
        </div>
    </div>
</div>


@stop