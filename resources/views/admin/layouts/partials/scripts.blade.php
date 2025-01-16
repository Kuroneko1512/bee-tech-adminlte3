<!-- jQuery -->
<script src="{{ asset('libs/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('libs/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('libs/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('libs/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('libs/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('libs/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('libs/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('libs/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('libs/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('libs/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('libs/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('libs/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('libs/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('libs/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('libs/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('libs/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('libs/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('libs/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>


<!-- Bootstrap Switch -->
<script src="{{ asset('libs/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- BS-Stepper -->
<script src="{{ asset('libs/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
<!-- dropzonejs -->
<script src="{{ asset('libs/plugins/dropzone/min/dropzone.min.js') }}"></script>
<!-- AdminLTE App -->
{{-- <script src="{{ asset('libs/dist/js/adminlte.min.js') }}"></script> --}}
<!-- AdminLTE App -->
<script src="{{ asset('libs/dist/js/adminlte.js') }}"></script>

<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('libs/dist/js/demo.js') }}"></script> --}}
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('libs/dist/js/pages/dashboard.js') }}"></script> --}}

<!-- Page specific script -->
<script>   

    function initDatetimePicker(inputId, datetimepickerId, enableTime = false) {
        // Định nghĩa các định dạng
        const formats = enableTime ?
            {
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

        // Phone VND

        // $("#phone-input").inputmask({
        //     mask: '[+]###################', // Giới hạn 20 sô
        //     greedy: false,
        //     removeMaskOnSubmit: true,
        //     definitions: {
        //         '#': {
        //             validator: "[0-9]"
        //         }
        //     },
        // });
        // $('form').on('submit', function() {
        //     $(this).find("#phone-input").inputmask('remove');
        // });

        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Datemask dd/mm/yyyy
        $('#datemask').inputmask('dd/mm/yyyy', {
            'placeholder': 'dd/mm/yyyy'
        })
        //Datemask2 mm/dd/yyyy
        $('#datemask2').inputmask('mm/dd/yyyy', {
            'placeholder': 'mm/dd/yyyy'
        })
        //Money Euro
        $('[data-mask]').inputmask()

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'L'
        });

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Date range picker
        $('#reservation').daterangepicker()
        //Date range picker with time picker
        $('#reservationtime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 30,
            locale: {
                format: 'MM/DD/YYYY hh:mm A'
            }
        })
        //Date range as a button
        $('#daterange-btn').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment().subtract(29, 'days'),
                endDate: moment()
            },
            function(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format(
                    'MMMM D, YYYY'))
            }
        )

        //Timepicker
        $('#timepicker').datetimepicker({
            format: 'LT'
        })

        //Bootstrap Duallistbox
        $('.duallistbox').bootstrapDualListbox()

        //Colorpicker
        $('.my-colorpicker1').colorpicker()
        //color picker with addon
        $('.my-colorpicker2').colorpicker()

        $('.my-colorpicker2').on('colorpickerChange', function(event) {
            $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
        })

        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })

        initDatetimePicker("birthday", "birthday-datetimepicker"); // Chỉ ngày
        initDatetimePicker("created_at", "created_at-datetimepicker", true); // Có cả ngày và giờ
        initDatetimePicker("expired-date", "expired-date-datetimepicker"); // Có cả ngày và giờ
    });

    // BS-Stepper Init
    // document.addEventListener('DOMContentLoaded', function() {
    //     window.stepper = new Stepper(document.querySelector('.bs-stepper'))
    // })
</script>
