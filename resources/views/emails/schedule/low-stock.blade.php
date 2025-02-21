@extends('layouts.email')

@section('content')
<div class="email-header">
    <h2>Thông báo hàng tồn kho thấp</h2>
</div>

<div class="email-content">
    <h2>Thông báo: Sản phẩm sắp hết hàng</h2>
    
    <p>Xin chào,</p>
    
    <p>Các sản phẩm sau đang có số lượng tồn kho thấp:</p>
    
    <table border="1" cellpadding="5">
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng còn lại</th>
        </tr>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->stock }}</td>
        </tr>
        @endforeach
    </table>
</div>
@endsection