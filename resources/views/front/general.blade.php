
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>

        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.3/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->


        <style>
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
                <a class="navbar-brand" href="#">Title</a>
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="">Home</a>
                    </li>
                    <li>
                        <a href="">Category</a>
                    </li>
                    <li>
                        <a href="">Products</a>
                    </li>
                </ul>
                <div class="">
                    @if (Auth::check())
                        <strong class="" style="color: #fff;">{{ Auth::User()->name }}</strong>
                        <form action="{{ route('logout', ['url.intended' => url()->current()]) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Đăng xuất</button>
                        </form>
                    @else
                        <strong>Bạn chưa đăng nhập</strong>
                        <a href="{{ route('login') }}" class="btn btn-primary">Đăng Nhập</a>
                    @endif
                </div>
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
        <div class="container">
            @yield('main')
        </div>
            
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>
</html>
