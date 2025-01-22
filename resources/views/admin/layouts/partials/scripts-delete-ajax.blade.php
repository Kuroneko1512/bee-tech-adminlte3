<script>
    // Delete with Ajax
    function deleteRow(url, rowElement, deleteId) {
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Xóa',
            cancelButtonText: 'Hủy',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url + deleteId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        if (response.success) {
                            // Xóa hàng tương ứng mà không tải lại trang
                            rowElement.fadeOut(300, function() {
                                $(this).remove();
                            });

                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Lỗi!',
                            'Đã xảy ra lỗi, vui lòng thử lại.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
