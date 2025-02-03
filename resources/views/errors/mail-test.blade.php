@extends('admin.layouts.master')

@section('content')
<div class="card">
    <div class="card-header bg-danger">
        <h3 class="card-title">Mail Test Error</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            {{ $error }}
        </div>
        <pre>{{ $trace }}</pre>
    </div>
</div>
@endsection
