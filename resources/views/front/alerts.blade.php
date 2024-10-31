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
    @if ($errors->getBag('frontErrors')->any())
        const errors = {!! json_encode($errors->getBag('frontErrors')->all()) !!};
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