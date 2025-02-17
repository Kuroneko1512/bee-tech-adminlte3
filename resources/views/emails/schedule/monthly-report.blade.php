@extends('layouts.email')

@section('content')
<div class="email-header">
    <h2>Báo cáo mua hàng tháng</h2>
</div>

<div class="email-content">
    <h2>Báo cáo mua hàng tháng {{ now()->subMonth()->format('m/Y') }}</h2>
    
    <p>Kính gửi quý khách,</p>
    
    <div style="margin: 20px 0;">
        <p><strong>Tổng số đơn hàng:</strong> {{ $reportData->total_orders }}</p>
        <p><strong>Tổng giá trị:</strong> {{ number_format($reportData->total_amount) }} VNĐ</p>
        <p><strong>Số lượng sản phẩm khác nhau:</strong> {{ $reportData->unique_products }}</p>
    </div>
</div>
@endsection