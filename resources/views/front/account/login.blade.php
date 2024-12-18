@extends('front.general')
@section('main')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Đăng Nhập</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('account.check_login') }}" method="POST" role="form">
                        @csrf
                        <div class="form-group">
                            <label for="email">Địa chỉ Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Mật Khẩu:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Ghi nhớ đăng nhập
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                    </form>

                    <hr>

                    <p class="text-center">
                        <a href="{{ route('front.forgot-password') }}">Quên mật khẩu?</a>
                    </p>
                    <p class="text-center">
                        <a href="{{ route('account.register') }}" class="btn btn-link">Chưa có tài khoản? Đăng ký ngay</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
