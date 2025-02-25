<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Chunk PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #333;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th>SKU</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Danh mục cha</th>
                <th>Tồn kho</th>
                <th>Giá</th>
                <th>Ngày hết hạn</th>
                <th>Ngày tạo</th>
                <th>Ngày cập nhật</th>
                <th>Tổng đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->sku }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category_name }}</td>
                    <td>{{ $item->parent_category_name }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->expired_at }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>{{ $item->total_orders }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
