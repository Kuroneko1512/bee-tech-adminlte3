@extends('admin.layouts.master')

@section('title')
    Order Detail #{{ $order->id }}
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Order #{{ $order->id }}</h3>
                        <div class="card-tools">
                            <a href="{{ route(getRouteName('orders.download'), $order->id) }}" class="btn btn-danger">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Order Information</h3>
                                <p><strong>Customer Name</strong> : {{ $order->customer->full_name }}</p>
                                <p><strong>Phone</strong> : {{ $order->customer->phone }}</p>
                                <p><strong>Address</strong> : {{ $order->customer->address }},
                                    {{ $order->customer->commune->name }},
                                    {{ $order->customer->district->name }}, {{ $order->customer->province->name }} </p>
                                <p><strong>CreateDate</strong> : {{ $order->created_at->format('d/m/Y H:i:s') }}</p>
                                <p><strong>Quantity</strong> : {{ $order->quantity }}</p>
                                <p><strong>Total Amount</strong> : {{ number_format($order->total) }} VND</p>
                            </div>
                        </div>

                        <h5 class="mt-4">Order Details</h5>
                        <table class="table table-bordered">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
