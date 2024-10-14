@extends('front.general')
@section('main')

<div class="container">
    <h2 class="text-center">Đăng Ký Khách Hàng</h2>
    <hr>
    <form action="{{ route('account.register') }}" method="POST" class="form-horizontal">
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

        <!-- Địa chỉ -->
        <div class="form-group">
            <label for="address" class="col-sm-2 control-label">Địa chỉ</label>
            <div class="col-sm-10">
                <input type="text" name="address" id="address" class="form-control" placeholder="Nhập địa chỉ" required>
            </div>
        </div>

        <!-- Số điện thoại -->
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Số điện thoại</label>
            <div class="col-sm-10">
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" required>
            </div>
        </div>

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email" required>
            </div>
        </div>

        <!-- Giới tính -->
        <div class="form-group">
            <label for="gender" class="col-sm-2 control-label">Giới tính</label>
            <div class="col-sm-10">
                <select name="gender" id="gender" class="form-control" required>
                    <option value="">Chọn giới tính</option>
                    <option value="male">Nam</option>
                    <option value="female">Nữ</option>
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
            <label for="confimr_password" class="col-sm-2 control-label">Xác nhận mật khẩu</label>
            <div class="col-sm-10">
                <input type="password" name="confimr_password" id="confimr_password" class="form-control" placeholder="Nhập lại mật khẩu" required>
            </div>
        </div>

        <!-- Nút Submit -->
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 text-center">
                <button type="submit" class="btn btn-primary">Đăng Ký</button>
            </div>
        </div>
    </form>
</div>

@stop