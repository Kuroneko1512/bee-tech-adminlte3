@extends('layouts.email')

@section('content')
    <div class="email-header">
        <h2>Báo cáo mua hàng tháng</h2>
    </div>

    <div class="email-content">
        <h2>Báo cáo mua hàng tháng {{ now()->subMonth()->format('m/Y') }}</h2>

        <table border="1">
            <tr>
                <th>Khách hàng</th>
                <th>Số điện thoại</th>
                <th>Email</th>
                <th>Số đơn hàng</th>
                <th>Tổng tiền</th>
                <th>Số SP khác nhau</th>
                <th>Tổng số lượng</th>
            </tr>
            @foreach ($reportData as $stat)
                <tr>
                    <td>{{ $stat->full_name }}</td>
                    <td>{{ $stat->phone }}</td>
                    <td>{{ $stat->email }}</td>
                    <td>{{ $stat->total_orders }}</td>
                    <td>{{ number_format($stat->total_amount) }}</td>
                    <td>{{ $stat->unique_products }}</td>
                    <td>{{ $stat->total_items }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
