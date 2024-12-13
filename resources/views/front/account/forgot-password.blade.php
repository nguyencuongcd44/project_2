@extends('front.general')
@section('main')

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Nhập Email để đặt lại mật khẩu</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('forgotPassword.sendEmail') }}" method="POST" role="form">
                        @csrf
                        <div class="form-group">
                            <label for="email">Địa chỉ Email:</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Gửi</button>
                    </form>

                    <hr>

                    <p class="text-center">
                        <a href="{{ route('account.login') }}">Đã có tài khoản? Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
