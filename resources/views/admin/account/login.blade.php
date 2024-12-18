<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <script type="text/javascript" src="\Js\jquery-3.7.1.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script src="https://kit.fontawesome.com/a34c25a309.js" crossorigin="anonymous"></script>
        <script src="/Js/sweetalert2@11.js"></script>
        <script src="/Js/customize.js"></script>

    </head>
    <body>
         <!-- Phần Thông Báo Lỗi -->
        @include('admin.alerts')

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title text-center">Đăng Nhập</h3>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route('admin.check_login') }}" method="POST" role="form">
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
                                <a href="">Quên mật khẩu?</a>
                            </p>
                            <p class="text-center">
                                <a href="{{ route('admin.register') }}" class="btn btn-link">Chưa có tài khoản? Đăng ký ngay</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>