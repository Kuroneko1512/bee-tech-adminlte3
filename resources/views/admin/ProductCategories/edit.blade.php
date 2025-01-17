@extends('admin.layouts.master')

@section('title')
    Update Category
@endsection

@section('contents')
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 m-auto">

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Category</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ route('categories.update', $category->id) }}" method="POST"
                        enctype="multipart/form-data">
                        {{-- <form action="" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <!-- Category Name -->
                            <div class="form-group">
                                <label for="InputCategoryName">Name</label>
                                <input type="text" class="form-control" id="InputCategoryName" name="name"
                                    placeholder="Enter Name" value="{{ old('name', $category->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Parent Category -->
                            <div class="form-group">
                                <label>Parent</label>
                                <select class="form-control select2 select2-blue" name="parent_id"
                                    data-dropdown-css-class="select2-navy" style="width: 100%;">
                                    <!-- Allow null -->
                                    <option value="">No Parent</option>
                                    @foreach ($categories as $parentCategory)
                                        <option value="{{ $parentCategory->id }}"
                                            {{ old('parent_id', $category->parent_id) == $parentCategory->id ? 'selected' : '' }}>
                                            {{ $parentCategory->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <span class="text-danger">{{ $message }}</span>
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
    </div><!-- /.container-fluid -->
@endsection

@push('scripts')
    @include('admin.layouts.partials.scripts-form')
@endpush
