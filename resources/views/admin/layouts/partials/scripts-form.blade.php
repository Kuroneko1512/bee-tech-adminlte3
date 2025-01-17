<script>
    function initDatetimePicker(inputId, datetimepickerId, enableTime = false) {
        // Định nghĩa các định dạng
        const formats = enableTime ? {
                inputFormat: "dd/mm/yyyy HH:MM",
                displayFormat: "DD/MM/YYYY HH:mm"
            } // Ngày + giờ
            :
            {
                inputFormat: "dd/mm/yyyy",
                displayFormat: "DD/MM/YYYY"
            }; // Chỉ ngày

        // Cấu hình InputMask
        $(`#${inputId}`).inputmask({
            alias: "datetime",
            inputFormat: formats.inputFormat,
            placeholder: formats.inputFormat,
            oncomplete: function() {
                const date = moment(this.value, formats.displayFormat);
                $(`#${datetimepickerId}`).datetimepicker("date", date);
            }
        });

        // Cấu hình TempusDominus
        $(`#${datetimepickerId}`).datetimepicker({
            format: formats.displayFormat, // Đồng bộ định dạng hiển thị
            defaultDate: moment(), // Ngày mặc định
            useCurrent: false, // Không tự động set giá trị hiện tại
            buttons: {
                showClear: true, // Hiển thị nút Clear
                showClose: true, // Hiển thị nút Close
                showToday: true, // Hiển thị nút Today 
            },
            icons: {
                time: "far fa-clock",
                date: 'far fa-calendar',
                up: 'fas fa-arrow-up',
                down: 'fas fa-arrow-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-calendar-check',
                clear: 'fas fa-trash', // Icon cho nút Clear
                close: 'fas fa-times', // Icon cho nút Close
            }
        });

        // Đồng bộ khi thay đổi dữ liệu trong TempusDominus
        $(`#${datetimepickerId}`).on("change.datetimepicker", function(e) {
            if (e.date) {
                const formattedDate = moment(e.date).format(formats.displayFormat);
                $(`#${inputId}`).val(formattedDate);
            } else {
                $(`#${inputId}`).val(""); // Xóa giá trị nếu không chọn
            }
        });
    }

    $(function() {
        // file input : change name when upload file
        bsCustomFileInput.init();

        //Initialize DateTime Input Mask + TempusDominus 
        initDatetimePicker("birthday", "birthday-datetimepicker"); // Chỉ ngày
        initDatetimePicker("created_at", "created_at-datetimepicker", true); // Có cả ngày và giờ
        initDatetimePicker("expired-date", "expired-date-datetimepicker"); // Có cả ngày và giờ

        // Preview 
        $('#preview-modal').on('show.bs.modal', function(e) {
            // Get form values
            $('#preview-name').text($('#InputProductName').val());
            $('#preview-sku').text($('#InputSKU').val());
            $('#preview-stock').text($('#InputStock').val());
            $('#preview-category').text($('.select2').find(':selected').text());
            $('#preview-expired').text($('#expired-date').val());

            // Handle avatar preview
            const avatarInput = $('#customFile')[0];
            if (avatarInput.files && avatarInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-avatar').html(
                        `<img src="${e.target.result}" class="img-fluid img-thumbnail">`);
                }
                reader.readAsDataURL(avatarInput.files[0]);
            } else {
                // Show existing image in edit mode
                const existingImage = $('.img-thumbnail').attr('src');
                if (existingImage) {
                    $('#preview-avatar').html(
                        `<img src="${existingImage}" class="img-fluid img-thumbnail">`);
                }
            }
        });

        // Tooltip
        $('[data-toggle="tooltip"]').tooltip();
    })
</script>
