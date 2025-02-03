@extends('admin.layouts.master')
@push('styles')
    {{-- @include('admin.layouts.partials.styles-table') --}}
@endpush


@section('title')
    Trang Chủ
@endsection

@section('contents')
    <div class="container-fluid">
        <h1>Trang Chủ</h1>

        <div class="row">
            <div class="col-6 m-auto">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Product</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    {{-- <form action="" method="POST" enctype="multipart/form-data"> --}}
                    <form action="{{ route(getRouteName('products.store')) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">

                            <div class="form-group">
                                <label for="InputProductName">Name</label>
                                <input type="text" class="form-control" id="InputProductName" name="name"
                                    placeholder="Enter Product Name" value="{{ old('name') }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputSKU">SKU</label>
                                <input type="text" class="form-control" id="InputSKU" name="sku"
                                    placeholder="Enter SKU" value="{{ old('sku') }}">
                                @error('sku')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="customFile">Avatar</label>

                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="avatar"
                                        value="">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="InputStock">Stock</label>
                                <input type="number" class="form-control" id="InputStock" name="stock"
                                    placeholder="Enter Last Name" value="{{ old('stock') }}">
                                @error('stock')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select2 select2-blue" name="category_id"
                                    data-dropdown-css-class="select2-navy" style="width: 100%;">
                                    {{-- @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach --}}
                                    <option value="">Select a category</option>
                                    <option value="1">Category 1</option>
                                    <option value="2">Category 2</option>
                                    <option value="3">Category 3</option>
                                    <option value="4">Category 4</option>
                                    <option value="5">Category 5</option>
                                </select>
                                @error('category_id')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="expired-date">Expired Date:</label>
                                <div class="input-group date" id="expired-date-datetimepicker">
                                    <div class="input-group-append" data-target="#expired-date-datetimepicker"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" name="expired_at"
                                        id="expired-date" data-target="#expired-date-datetimepicker"
                                        value="{{ old('expired_at') }}">
                                </div>
                                @error('expired_at')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    {{-- @include('admin.layouts.partials.scripts-table') --}}
@endpush
