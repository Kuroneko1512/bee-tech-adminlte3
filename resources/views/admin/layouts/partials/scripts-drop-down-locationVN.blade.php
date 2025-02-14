<script>
    $(function() {
        // Khởi tạo giá trị đã chọn
        let selectedProvince = '{{ $selectedProvince ?? '' }}';
        let selectedDistrict = '{{ $selectedDistrict ?? '' }}';
        let selectedCommune = '{{ $selectedCommune ?? '' }}';

        // Load danh sách tỉnh/thành
        $.get('/api/v1/locations/provinces', function(res) {
            if (res.success) {
                res.data.forEach(function(province) {
                    let selected = province.id == selectedProvince ? 'selected' : '';
                    $('#province').append(
                        `<option value="${province.id}" ${selected}>${province.name}</option>`
                    );
                });
                if (selectedProvince) $('#province').trigger('change');
            }
        });

        // Xử lý chọn tỉnh/thành
        $('#province').change(function() {
            let provinceId = $(this).val();
            $('#district').empty().append('<option value="">Chọn quận/huyện</option>');
            $('#commune').empty().append('<option value="">Chọn xã/phường</option>');

            if (provinceId) {
                $.get(`/api/v1/locations/districts/${provinceId}`, function(res) {
                    if (res.success) {
                        res.data.forEach(function(district) {
                            let selected = district.id == selectedDistrict ?
                                'selected' : '';
                            $('#district').append(
                                `<option value="${district.id}" ${selected}>${district.name}</option>`
                            );
                        });
                        if (selectedDistrict) $('#district').trigger('change');
                    }
                });
            }
        });

        // Xử lý chọn quận/huyện
        $('#district').change(function() {
            let districtId = $(this).val();
            $('#commune').empty().append('<option value="">Chọn xã/phường</option>');

            if (districtId) {
                $.get(`/api/v1/locations/communes/${districtId}`, function(res) {
                    if (res.success) {
                        res.data.forEach(function(commune) {
                            let selected = commune.id == selectedCommune ? 'selected' :
                                '';
                            $('#commune').append(
                                `<option value="${commune.id}" ${selected}>${commune.name}</option>`
                            );
                        });
                    }
                });
            }
        });
    });
</script>
