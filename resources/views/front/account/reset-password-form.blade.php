@extends('front.general')
@section('main')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Đặt Lại Mật Khẩu</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('front.password.reset') }}" method="POST" role="form">
                        @csrf
                        <!-- Token Reset Password -->
                        <input type="hidden" name="token" value="{{ $tokenRecord->token }}">

                        <div class="form-group">
                            <label for="password">Mật Khẩu Mới:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Xác Nhận Mật Khẩu Mới:</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Cập Nhật Mật Khẩu</button>
                    </form>

                    <hr>

                    <p class="text-center">
                        <a href="{{ route('account.login') }}">Quay lại trang đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
