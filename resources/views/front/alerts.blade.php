<style>
    .error{
        li{
            list-style: none;
        }
    }

    .my-swal-title{
        font-size: 16px;
        font-weight: bolder;
    }

    .my-swal-content{
        font-size: 16px;
    }
</style>

<script>
    // Thiết lập cấu hình mặc định cho SweetAlert
    const defaultSwal = Swal.mixin({
        position: 'center',
        confirmButtonColor: '#5cb85c',
        cancelButtonColor: '#d9534f',
        confirmButtonText: 'OK',
        cancelButtonText: 'Huỷ',
        buttonsStyling: true,
        customClass: {
            popup: 'my-swal-popup',
            title: 'my-swal-title',
            confirmButton: 'my-swal-confirm-btn',
            cancelButton: 'my-swal-cancel-btn',
            content: 'my-swal-content'
        }
    });

    // Xác nhận trước khi xóa
    function deleteConfirm(url) {
        event.preventDefault();
        
        defaultSwal.fire({
            title: 'Xác Nhận',
            text: "Bạn có chắc chắn muốn xóa!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Quay Lại'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = url;
            }
        });
    }
    
    // Hàm hiển thị thông báo lỗi
    function showErrorAlert(errors) {
        let errorHtml = '<ul class="error danger text-danger">';

        if(typeof errors === 'string'){
            errorHtml += `<li>${errors}</li>`;

        }else if(typeof errors === 'object'){
            errors.forEach(error => {
                errorHtml += `<li>${error}</li>`;
            });
        }
        errorHtml += '</ul>';

        defaultSwal.fire({
            icon: 'error',
            title: 'Đã xảy ra lỗi !',
            html: errorHtml,
        });
    }

    // Hàm hiển thị thông báo thành công
    function showSuccessAlert(message) {
        defaultSwal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Thành Công !',
            text: message,
            timer: 3000,
            timerProgressBar: true
        });
    }

    // Hàm hiển thị Cảnh báo
    function showWarningAlert(message) {
        defaultSwal.fire({
            icon: 'warning',
            title: 'Cảnh Báo !',
            text: message,
            timer: 5000,
            timerProgressBar: true
        });
    }

    // Hàm hiển thị Cảnh báo
    function showInfoAlert(message) {
        defaultSwal.fire({
            icon: 'info',
            title: 'Lưu Ý !',
            text: message,
            timer: 5000,
            timerProgressBar: true
        });
    }

    // Kiểm tra và hiển thị các thông báo từ session
    @if ($errors->any())
        const errors = {!! json_encode($errors->all()) !!};
        showErrorAlert(errors);
    @endif

    @if (session('error'))
        const errorMessage = "{{ session('error') }}";
        showErrorAlert(errorMessage);
    @endif

    @if (session('success'))
        const successMessage = "{{ session('success') }}";
        showSuccessAlert(successMessage);
    @endif

    @if (session('warning'))
        const warningMessage = "{{ session('warning') }}";
        showSuccessAlert(warningMessage);
    @endif

    @if (session('info'))
        const infoMessage = "{{ session('info') }}";
        showSuccessAlert(infoMessage);
    @endif
</script>