@extends('admin.layouts.master')

@section('title')
    List Products
@endsection

@section('contents')
    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">List Products</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>SKU</th>
                                {{-- <th>Avatar</th> --}}
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Expired Date</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td> {{ $product->id }}</td>
                                    {{-- <td> {{ $product->name }}</td> --}}
                                    <td>
                                        <a href="#" class="d-flex align-items-center text-secondary">
                                            <img src="{{ $product->avatar ? Storage::url($product->avatar) : Storage::url('/default/ComingSoon.jpg') }}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid img-rounded img-md elevation-2" >
                                            <span class="ml-2">{{ $product->name }}</span>
                                        </a>
                                    </td>
                                    <td> {{ $product->sku }}</td>
                                    <td> {{ optional($product->category)->name }} </td>
                                    <td> {{ $product->stock }} </td>
                                    <td> {{ $product->expired_at ? $product->expired_at->format('d/m/Y') : '' }}</td>
                                    <td> {{ $product->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td> {{ $product->updated_at->format('d/m/Y H:i:s') }}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                                        <a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>SKU</th>
                                {{-- <th>Avatar</th> --}}
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Expired Date</th>
                                <th>Create Date</th>
                                <th>Update Date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                    {{ $products->links() }}
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
