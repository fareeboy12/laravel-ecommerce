@extends('layouts.app')

@section('title', 'Upload Bulk Products')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 mt-5">
            <form action="{{ route('products.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file">Upload CSV</label>
                    <input type="file" name="csv_file" class="form-control-file" id="csv_file" accept=".csv" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>
</div>
@endsection