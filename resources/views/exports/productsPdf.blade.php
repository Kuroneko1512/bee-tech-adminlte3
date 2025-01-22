<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Danh sách sản phẩm</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; } /* Font DejaVu Sans, fallback là sans-serif */
        h1 { text-align: center; margin-bottom: 20px;}
        p { text-align: center; margin-bottom: 20px;}
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left;} /* Tăng padding để dễ đọc hơn */
        th { background-color: #f2f2f2; } /* Màu nền cho header */
    </style>
</head>
<body>
    <h1>Danh sách sản phẩm</h1>
    <p>Ngày: {{ now()->format('d/m/Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>SKU</th>
                <th>Danh mục</th>
                <th>Hàng tồn kho</th>
                <th>Hạn sử dụng</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ optional($product->category)->name }}</td>
                <td>{{ $product->stock }}</td>
                <td>{{ optional($product->expired_at)->format('d/m/Y') }}</td>
                <td>{{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                <td>{{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>