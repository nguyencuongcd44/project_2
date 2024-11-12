
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home</title>

        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/Js/slick-1.8.1/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="/Js/slick-1.8.1/slick/slick-theme.css"/>
        
        <script type="text/javascript" src="\Js\jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="/Js/jquery-ui-1.14.1/jquery-ui.min.js"></script>
        <script src="https://kit.fontawesome.com/a34c25a309.js" crossorigin="anonymous"></script>
        <script src="/Js/sweetalert2@11.js"></script>
        <script src="/Js/customize.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/Js/slick-1.8.1/slick/slick.min.js"></script>

        <style>
            .navbar{
                background-color: #a5d1a1;
            }
            .navbar-nav{
                li{
                    a{
                        background-color: unset;
                    }
                }
            }
            .navbar .form-control.search-keyword {
                width: 500px; 
            }
            #searchResults {
                max-height: 300px; 
                overflow-y: auto; 
                position: absolute;
                z-index: 1000;
                background-color: white;
                width: 500px;
                border: 1px solid #ccc; 
                box-shadow: 0 2px 10px rgba(0,0,0,0.1); 
            }
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
                <ul class="nav navbar-nav">
                    <li class="">
                        <a href="/">Home</a>
                    </li>

                    <li class="">
                        <a href="{{ route('favorite') }}">Favorites</a>
                    </li>

                    <li class="">
                        <a href="{{ route('front.toppings') }}">Toppings</a>
                    </li>
                </ul>
               

                <ul class="nav navbar-nav navbar-center">
                    <form method="GET" action="{{ route('front.search') }}" class="navbar-form navbar-left" id="searchForm">
                        <div class="form-group">
                            <!-- Input tìm kiếm sản phẩm -->
                            <input type="text" id="searchKeyword" class="form-control search-input search-keyword" name="keyWord" 
                            value="{{ session('searchConditions.keyWord','') }}" placeholder="Tìm kiếm tên sản phẩm..." autocomplete="off">
                            
                            <!-- Khu vực hiển thị nút điều kiện và nút tìm kiếm -->
                            <button type="button" id="toggleFilters" class="btn btn-secondary">
                                Điều kiện
                            </button>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                        
                        <!-- Khu vực điều kiện tìm kiếm ẩn -->
                        <div id="searchFilters" style="display: none;">
                            <div class="form-group">
                                <label for="categoryFilter">Danh mục:</label>
                                <select id="categoryFilter" class="form-control search-input" name="Category">
                                    <option value="">Tất cả</option>
                                    @foreach($cats as $cat)
                                        <option value="{{ $cat->id }}" {{ $cat->id == session('searchConditions.Category','')? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pro_number">Mã sản phẩm:</label>
                                <input type="text" id="pro_number" class="form-control search-input" name="productNumber" value="{{ session('searchConditions.productNumber','') }}">
                            </div>
                            <div class="form-group">
                                <label for="minPrice">Giá thấp nhất:</label>
                                <input type="number" id="minPrice" class="form-control search-input" name="minPrice" value="{{ session('searchConditions.minPrice','') }}" min=1000>
                            </div>
                            <div class="form-group">
                                <label for="maxPrice">Giá cao nhất:</label>
                                <input type="number" id="maxPrice" class="form-control search-input" name="maxPrice" value="{{ session('searchConditions.maxPrice', '') }}">
                            </div>
                            <div class="form-group">
                                <button type="button" id="search-reset" class="btn btn-danger">Reset</button>
                            </div>
                        </div>
        
                        <!-- Khu vực hiển thị kết quả tìm kiếm -->
                        <div id="searchResults" class="list-group" style="display: none; position: absolute; z-index: 1000; background-color: white;">
                            <!-- Kết quả tìm kiếm sẽ hiển thị tại đây -->
                        </div>
                    </form>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('cart') }}">
                            <i class="fa fa-shopping-cart fa-2x cart"></i>
                            <span class="qtt-bg">
                                <strong class="qtt-number">{{ $cart->totalQuantity }}</strong>
                            </span>
                        </a>
                    </li>
    
                    @if (Auth::guard('cus')->check())
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
            
        <script>
            $(document).ready(function() {
                $('#toggleFilters').on('click', function() {
                    $('#searchFilters').toggle();
                });
            
                $('#searchKeyword').on('focus', function() {
                    $('#searchResults').show();
                });
            
                let timeout;
                $('#searchKeyword').on('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(function() {
                        let keyword = $('#searchKeyword').val();
                        if(keyword != ''){
                            searchProducts(keyword);
                        }
                    }, 800); 
                });

                
                // Ẩn khu vực kết quả khi nhấp ra ngoài
                $(document).click(function(e) {
                    if (!$(e.target).closest('#searchForm').length) {
                        $('#searchResults').hide();
                    }
                });

                // xóa điều kiện tìm kiếm
                $('#search-reset').on('click', function() {
                    $.ajax({
                        url: "{{ route('front.search_reset') }}",
                        method: 'POST',
                        data: '',
                        success: function(response) {
                            if(response.status == 'OK'){
                                window.location.href = "/";
                            }
                        }
                    });
                });
            });

            function searchProducts(keyword) {
                let Category = $('#categoryFilter').val();
                let minPrice = $('#minPrice').val();
                let maxPrice = $('#maxPrice').val();
                let producNumber = $('#pro_number').val();
        
                $.ajax({
                    url: "{{ route('front.search') }}",
                    method: 'GET',
                    data: {
                        keyWord: keyword,
                        Category: Category,
                        productNumber: producNumber,
                        minPrice: minPrice,
                        maxPrice: maxPrice
                    },
                    success: function(products) {
                        $('#searchResults').empty();
                        if (products.length > 0) {
                            $.each(products, function(index, product) {
                                $('#searchResults').append(
                                    `<a href="/product/${product.id}" class="list-group-item">${product.name} - ${product.price} đ</a>`
                                );
                            });
                        } else {
                            $('#searchResults').append('<p class="list-group-item">Không tìm thấy sản phẩm nào.</p>');
                        }
                    }
                });
            }
        </script>
    </body>
</html>
