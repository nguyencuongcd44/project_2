@extends('front.general')
@section('main')

<style>
    /* Tùy chỉnh căn chỉnh và hiển thị */
    .payment-method {
        margin-top: 30px;
    }

    .payment-option {
        margin-bottom: 20px;
    }

    .form-section {
        display: none;
        margin-top: 20px;
    }

    /* Căn chỉnh các nút xác nhận và quay lại */
    .btn-group {
        margin-top: 30px;
    }
</style>

<div class="container">
    <h2 class="text-center">Chọn Phương Thức Thanh Toán</h2>

    <div class="payment-method">
        <div class="form-group">
            <label><strong>Phương thức thanh toán:</strong></label>
            <select id="paymentMethod" class="form-control">
                <option value="">Chọn phương thức</option>
                <option value="COD">Thanh toán khi nhận hàng (COD)</option>
                <option value="QR">Thanh toán bằng mã QR</option>
            </select>
        </div>

        <!-- Phần nhập thông tin cho COD -->
        <div id="codFields" class="form-section">
            <h4>Thông tin nhận hàng</h4>
            <div class="form-group">
                <label for="name">Tên:</label>
                <input type="text" id="name" class="form-control" placeholder="Nhập tên của bạn">
            </div>
            <div class="form-group">
                <label for="address">Địa chỉ:</label>
                <input type="text" id="address" class="form-control" placeholder="Nhập địa chỉ nhận hàng">
            </div>
            <div class="form-group">
                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại">
            </div>
        </div>

        <!-- Phần hiển thị các cổng thanh toán QR -->
        <div id="qrFields" class="form-section">
            <h4>Chọn cổng thanh toán QR</h4>
            <div class="payment-option">
                <label class="radio-inline">
                    <input type="radio" name="qrPaymentOption" value="zalopay"> ZaloPay
                </label>
                <label class="radio-inline">
                    <input type="radio" name="qrPaymentOption" value="vnpay"> VNPay
                </label>
                <label class="radio-inline">
                    <input type="radio" name="qrPaymentOption" value="momo"> Momo
                </label>
            </div>
        </div>

        <!-- Các nút xác nhận và quay lại -->
        <div class="btn-group pull-right">
            <button id="submit" class="btn btn-primary">Xác nhận</button>
            <button class="btn btn-default">Quay lại</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#paymentMethod').change(function() {
            var selectedMethod = $(this).val();
            if (selectedMethod === 'COD') {
                $('#codFields').show();
                $('#qrFields').hide();
            } else if (selectedMethod === 'QR') {
                $('#qrFields').show();
                $('#codFields').hide();
            } else {
                $('.form-section').hide();
            }
        });


        $('#submit').on('click', function(){
            // Hiển thị SweetAlert khi khách hàng ấn nút "Xác nhận đơn hàng"
            Swal.fire({
                title: 'Đang chờ xác nhận từ cửa hàng',
                html: 'Đơn hàng của bạn đang chờ xác nhận. Vui lòng chờ trong giây lát...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                timer: 5000, 
                didOpen: () => {
                    Swal.showLoading(); // Hiển thị hình ảnh động chờ

                    // Lắng nghe sự kiện phản hồi từ Staff qua WebSocket (cần có Laravel Echo)
                    Echo.channel('customer-orders')
                        .listen('OrderStatusUpdated', (event) => {
                            if (event.orderStatus === 'accepted') {
                                Swal.close();
                                Swal.fire('Thành công!', 'Đơn hàng của bạn đã được chấp nhận!', 'success');
                            } else if (event.orderStatus === 'rejected') {
                                Swal.close();
                                Swal.fire('Đơn hàng bị từ chối', 'Đơn hàng của bạn đã bị từ chối. Xin lỗi vì sự bất tiện này!', 'error');
                            }
                        });
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    // Xử lý khi hết thời gian (5 phút) mà Staff không phản hồi
                    Swal.fire('Hết thời gian chờ', 'Đơn hàng của bạn đã bị hủy do không có phản hồi từ cửa hàng.', 'error');
                }
            });
        })
    });
</script>

@stop
