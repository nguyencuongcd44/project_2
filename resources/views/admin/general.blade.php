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

    <div class="container">
        @yield('main')
    </div>
</body>
</html>
