@extends('admin.general')
@section('main')

<style>
    img{
        max-width: 200px;
        height: auto;
    }
</style>
<h1>Toppings</h1>
<a href="{{ route('topping.create')}}" class="btn btn-success">Thêm Mới</a>
<hr>

<table class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Ảnh</th>
            <th>Giá (vnd)</th>
            <th>Loại</th>
            <th>Liên kết</th>
            <th>Status</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($toppings as $topping)
        <tr>
            <td>{{ $topping->id}}</td>

            <td>{{ $topping->name}}</td>

            <td>
                <img src="/topping_img/{{ $topping->image }}" alt="{{ $topping->name}}"></img>
            </td>

            <td>{{ formatPrice($topping->price)}} VND</td>
            
            <td>
                @if ($topping->type == 0)
                    <p>Topping riêng</p>
                @else
                    <p>Topping kèm sản phẩm</p>
                @endif
            </td>

            <td>
                @if($topping->products->isEmpty())
                    <em>Không có sản phẩm liên kết</em>
                @else
                    <ul>
                        @foreach($topping->products as $product)
                            <li>{{ $product->name }}</li>
                        @endforeach
                    </ul>
                @endif
            </td>

            <td>{{ $topping->status == 0 ? 'Tạm Ẩn' : 'Hiển Thị'}}</td>

            <td>
                <form id="deleteForm{{$topping->id}}" action="{{ route('topping.destroy', $topping->id) }}" method="POST" role="form">
                    @csrf @method('DELETE')
                    <a href="{{ route('topping.edit', $topping->id) }}" class="btn btn-sm btn-primary">Sửa</a>
                    <button onclick="formDeleteConfirm('{{ $topping->id }}')" class="btn btn-sm btn-danger">Xóa</button>
                </form>
            </td>
        </tr>

        @endforeach
    </tbody>
</table>


@stop