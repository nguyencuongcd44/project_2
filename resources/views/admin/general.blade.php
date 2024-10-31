<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a34c25a309.js" crossorigin="anonymous"></script>


    <script src="/Js/sweetalert2@11.js"></script>
    <script src="/Js/customize.js"></script>
    <script type="text/javascript" src="\Js\jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="/Js/jquery-ui-1.14.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Title</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="{{ route('admin.index')}}">Home</a>
                </li>
                <li>
                    <a href="{{ route('category.index')}}">Category</a>
                </li>
                <li>
                    <a href="{{ route('product.index')}}">Products</a>
                </li>
            </ul>

            <!-- Tên user và nút đăng xuất -->
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                    <li class="navbar-text">
                        <span>{{ Auth::user()->name }}</span>
                    </li>
                    <li>
                        <a href="{{ route('admin.logout') }}" class="btn btn-danger navbar-btn">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-primary">
                    <!-- Panel content here -->
                </div>
            </div>
        </div>
    </div>

    <!-- Phần Thông Báo Lỗi -->
    @include('admin.alerts')
    
    <div class="container">
        @yield('main')
    </div>
</body>
</html>
