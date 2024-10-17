<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- jQuery -->
        <script type="text/javascript" src="\Js\jquery-3.7.1.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
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
                                @if($errors->any())
                                    <div>
                                        @foreach ($errors->all() as $error)
                                            <p class="text-danger">{{ $error }}</p>
                                        @endforeach
                                    </div>
                                @endif
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