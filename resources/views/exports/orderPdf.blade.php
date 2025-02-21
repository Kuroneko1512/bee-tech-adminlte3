<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order #{{ $order->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Order Detail #{{ $order->id }}</h1>

    <div>
        <p><strong>Customer Name:</strong> {{ $order->customer->full_name }}</p>
        <p><strong>Phone:</strong> {{ $order->customer->phone }}</p>
        <p><strong>Address:</strong> {{ $order->customer->address }}, {{ $order->customer->commune->name }},
            {{ $order->customer->district->name }}, {{ $order->customer->province->name }} </p>
        <p><strong>Date:</strong> {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
        <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
        <p><strong>Total Amount:</strong> {{ number_format($order->total) }} VND</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td>{{ number_format($detail->price) }} VND</td>
                    <td>{{ $detail->quantity }}</td>
                    <td>{{ number_format($detail->price * $detail->quantity) }} VND</td>
                    <td>{{ $detail->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
