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
<!-- SweetAlert2 -->
<script src="{{ asset('libs/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('libs/plugins/toastr/toastr.min.js') }}"></script>
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
    $(function() {

        //Initialize Select2 Elements
        $('.select2').select2()

    });
</script>
