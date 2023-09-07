@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('add_category') }}">Add Category</a></li>
    </ol>

</nav>


<div class="row">
    <div class="col-md-8">
        @if (session('message'))
            <div class="alert alert-primary">
                {{ session('message') }}
            </div>
        @endif
        @if (session('message2'))
        <div class="alert alert-primary">
            {{ session('message2') }}
        </div>
    @endif
        <div class="card">
            <div class="card-header">
                <h4>Add Category</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('store_category') }}" method="POST" enctype="multipart/form-data" >
                    @csrf

                    <label>Category Name</label>
                    <input type="text" name="category_name" class="form-control my-1">
                    @error('category_name')
                        <p class="text-danger" >{{ $message }}</p>
                    @enderror

                    <label>Category Image</label>
                    <input type="file" name="category_image" class="form-control my-1">
                    @error('category_image')
                        <p class="text-danger" >{{ $message }}</p>
                    @enderror

                    <button type="submit" class="btn btn-info mt-3" >Add Category</button>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
