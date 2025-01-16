@extends('admin.layouts.master')

@section('title')
    Update Product
@endsection

@section('contents')
    <div class="row">
        <div class="col-6 m-auto">

            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Update Product</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="InputProductName">Name</label>
                            <input type="text" class="form-control" id="InputProductName" name="name"
                                placeholder="Enter Product Name" value="{{ old('name', $product->name) }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- SKU -->
                        <div class="form-group">
                            <label for="InputSKU">SKU</label>
                            <input type="text" class="form-control" id="InputSKU" name="sku"
                                placeholder="Enter SKU" value="{{ old('sku', $product->sku) }}">
                            @error('sku')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Avatar -->
                        <div class="form-group">
                            <label for="customFile">Avatar</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="avatar">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <div class="mt-2">
                                @if ($product->avatar)
                                    <img src="{{ asset('storage/' . $product->avatar) }}" alt="Product Avatar" class="img-thumbnail" width="100">
                                @endif
                            </div>
                            @error('avatar')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Stock -->
                        <div class="form-group">
                            <label for="InputStock">Stock</label>
                            <input type="number" class="form-control" id="InputStock" name="stock"
                                placeholder="Enter Stock" value="{{ old('stock', $product->stock) }}">
                            @error('stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control select2 select2-blue" name="category_id"
                                data-dropdown-css-class="select2-navy" style="width: 100%;">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Expired Date -->
                        <div class="form-group">
                            <label for="expired-date">Expired Date:</label>
                            <div class="input-group date" id="expired-date-datetimepicker">
                                <div class="input-group-append" data-target="#expired-date-datetimepicker"
                                    data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                                <input type="text" class="form-control datetimepicker-input" name="expired_at"
                                    id="expired-date" data-target="#expired-date-datetimepicker" 
                                    value="{{ old('expired_at', $product->expired_at->format('d/m/Y')) }}">
                            </div>
                            @error('expired_at')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
