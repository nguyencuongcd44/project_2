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

// Xác nhận trước khi xóa (trường hợp dùng thẻ a)
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

// Xác nhận trước khi xóa (trường hợp submit form)
function formDeleteConfirm(formId) {
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
            document.getElementById('deleteForm' + formId).submit();
        }
    });
}

// Update comment
function updateComment(url, commentId) {
    var oldComment = $('#commentText' + commentId).text();
    Swal.fire({
        title: 'Chỉnh sửa bình luận',
        input: 'textarea',
        inputValue: oldComment,
        showCancelButton: true,
        confirmButtonText: 'Lưu',
        cancelButtonText: 'Hủy',
        inputValidator: (value) => {
            if (!value) {
                return 'Nội dung bình luận không được để trống!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url, 
                method: 'put', 
                data: {
                    id: commentId,
                    text: result.value,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cập nhật thành công!',
                        text: 'Bình luận của bạn đã được cập nhật.'
                    }).then(() => {
                        location.reload(); 
                    });
                },
                error: function(error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Không thể cập nhật bình luận, vui lòng thử lại sau.'
                    });
                }
            });
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
    console.log(message);
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
