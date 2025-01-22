@extends('admin.layouts.master')

@section('title')
    Update Product
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 m-auto">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Product</h3>
                    </div>
                    <!-- /.card-header -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <strong>{{ session('info') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
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
                                        <img src="{{ asset('storage/' . $product->avatar) }}" alt="Product Avatar"
                                            class="img-thumbnail" width="100">
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
                                        value="{{ old('expired_at', optional($product->expired_at)->format('d/m/Y')) }}">
                                </div>
                                @error('expired_at')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#preview-modal">
                                <i class="fas fa-eye"></i> Preview
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->

    <!-- Preview Modal -->
    <div class="modal fade" id="preview-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- Header -->
                <div class="modal-header bg-primary text-white">
                    <h3 class="modal-title">Product Preview</h3>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Left Column: Avatar -->
                        <div class="col-md-4 text-center">
                            <div id="preview-avatar" style="width: 175px; margin: auto;">
                                <!-- Hình ảnh được truyền từ JS -->
                            </div>
                        </div>

                        <!-- Right Column: Product Details -->
                        <div class="col-md-8">
                            <!-- Name -->
                            <h4 id="preview-name" class="font-weight-bold text-primary"></h4>

                            <!-- SKU -->
                            <p>
                                <strong>SKU:</strong>
                                <span id="preview-sku" data-toggle="tooltip" title="Stock Keeping Unit"></span>
                            </p>

                            <!-- Stock -->
                            <p>
                                <strong>Stock:</strong>
                                <span id="preview-stock" class="badge badge-success"></span>
                            </p>

                            <!-- Category -->
                            <p>
                                <strong>Category:</strong>
                                <span id="preview-category" class="badge badge-info"></span>
                            </p>

                            <!-- Expired Date -->
                            <p>
                                <strong>Expired Date:</strong>
                                <span id="preview-expired"></span>
                            </p>
                        </div>
                    </div>

                    <!-- Tabs for Additional Information -->
                    <div class="mt-4">
                        <ul class="nav nav-tabs" id="preview-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details"
                                    role="tab" aria-controls="details" aria-selected="true">Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab"
                                    aria-controls="reviews" aria-selected="false">Reviews</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="preview-tab-content">
                            <!-- Details Tab -->
                            <div class="tab-pane fade show active" id="details" role="tabpanel"
                                aria-labelledby="details-tab">
                                <p id="preview-details" class="mt-3"></p>
                            </div>
                            <!-- Reviews Tab -->
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <p id="preview-reviews" class="mt-3"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('admin.layouts.partials.scripts-form')
@endpush
