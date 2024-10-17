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
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center">Đăng Ký Admin</h3>
                    </div>
                    <div class="panel-body">
                        <form action="{{ route('admin.register') }}" method="POST" class="form-horizontal">
                            @csrf
                            @if($errors->any())
                                <div>
                                    @foreach ($errors->all() as $error)
                                        <p class="text-danger">{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                        
                            <!-- Tên -->
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Tên</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên của bạn" required>
                                </div>
                            </div>
                        
                            <!-- Email -->
                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
                                </div>
                            </div>

                            <!-- Chọn vai trò -->
                            <div class="form-group">
                                <label for="role" class="col-sm-2 control-label">Vai trò</label>
                                <div class="col-sm-10">
                                    <select name="role" id="role" class="form-control" required>
                                        <option value="" disabled selected>Chọn vai trò</option>
                                        <option value="admin">Admin</option>
                                        <option value="editor">Editor</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Mật khẩu -->
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Mật khẩu</label>
                                <div class="col-sm-10">
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Nhập mật khẩu" required>
                                </div>
                            </div>
                        
                            <!-- Xác nhận mật khẩu -->
                            <div class="form-group">
                                <label for="confirm_password" class="col-sm-2 control-label">Xác nhận mật khẩu</label>
                                <div class="col-sm-10">
                                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu" required>
                                </div>
                            </div>
                        
                            
                        
                            <!-- Nút Submit -->
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10 text-center">
                                    <button type="submit" class="btn btn-primary">Đăng Ký</button>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <p class="text-center">
                            <a href="{{ route('admin.login') }}" class="btn btn-link">Đăng nhập</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>