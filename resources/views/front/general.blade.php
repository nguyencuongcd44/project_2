
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a34c25a309.js" crossorigin="anonymous"></script>

        <!-- sweetalert -->
        <script src="/Js/sweetalert2@11.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        <style>
            .cart{
                position: relative;
            }
            .qtt-bg{
                position: absolute;
                top: 0;
                right: 0;
                width: 25px;
                height: 25px;
                border-radius: 50%;
                background-color: red;
                display: flex;
                justify-content: center;
                align-content: center;
                
                .qtt-number{
                    color: white;
                }
            }
            .container{
                .panel{
                    border-radius: 0;

                    .list-group{
                        display: flex;
                        justify-content: space-around;

                        .list-group-item{
                            margin-bottom: 0;
                            width: 100%;
                            text-align: center;
                            border-radius: 0 !important;
                            border: none;
                        }
                        .list-group-item:hover{
                            background-color: #5cb85c;
                            color: #fff;
                        }
                    }
                }
                 
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <!-- Navbar Brand -->
                <a class="navbar-brand" href="#">Title</a>
    
                <!-- Menu Items căn trái -->
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="/">Home</a>
                    </li>
                </ul>
                
                <!-- Phần này căn phải -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Cart Icon -->
                    <li>
                        <a href="{{ route('cart') }}">
                            <i class="fa fa-shopping-cart fa-2x cart"></i>
                            <span class="qtt-bg">
                                <strong class="qtt-number">{{ $cart->totalQuantity }}</strong>
                            </span>
                        </a>
                    </li>
    
                    <!-- Kiểm tra người dùng đã đăng nhập hay chưa -->
                    @if (Auth::guard('cus')->check())
                        <!-- Hiển thị tên người dùng và nút đăng xuất -->
                        <li>
                            <strong class="navbar-text" style="color: #fff;">{{ Auth::guard('cus')->user()->name }}</strong>
                        </li>
                        <li>
                            <form action="{{ route('account.logout', ['url.intended' => url()->current()]) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger navbar-btn">Đăng xuất</button>
                            </form>
                        </li>
                    @else
                        <!-- Hiển thị nút đăng nhập nếu chưa đăng nhập -->
                        <li>
                            <a href="{{ route('account.login') }}" class="btn btn-primary navbar-btn">Đăng Nhập</a>
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
    
        <div class="container">
            <div class="row">
                <div class="col-md">
                    <div class="panel panel-primary">
                        <div class="list-group">
                            @foreach($cats as $cat)
                                <a href="{{ route('front.category', $cat)}}" class="list-group-item">{{ $cat->name }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần Thông Báo Lỗi -->
        @include('front.alerts')
    
        <div class="container">
            @yield('main')
        </div>
            
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
