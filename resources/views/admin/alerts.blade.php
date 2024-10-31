<style>
    .error{
        padding: 0;
        
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
    // Kiểm tra và hiển thị các thông báo từ session
    @if ($errors->getBag('adminErrors')->any())
        const errors = {!! json_encode($errors->getBag('adminErrors')->all()) !!};
        showErrorAlert(errors);
    @endif

    @if (session('admin_error'))
        const errorMessage = "{{ session('admin_error') }}";
        showErrorAlert(errorMessage);
    @endif

    @if (session('admin_success'))
        const successMessage = "{{ session('admin_success') }}";
        showSuccessAlert(successMessage);
    @endif

    @if (session('admin_warning'))
        const warningMessage = "{{ session('admin_warning') }}";
        showSuccessAlert(warningMessage);
    @endif

    @if (session('admin_info'))
        const infoMessage = "{{ session('admin_info') }}";
        showSuccessAlert(infoMessage);
    @endif
</script>