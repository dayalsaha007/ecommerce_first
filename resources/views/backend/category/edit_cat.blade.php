@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('all_category') }}">All category</a></li>

    </ol>


    <div class="row">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <h4>Edit Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_cat') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <label>Category Name</label>
                        <input type="text" name="category_name" value="{{ $cat_info->category_name }}" class="form-control my-1">
                        @error('category_name')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <label>Category Image</label>
                        <input type="file" name="category_image" class="form-control my-1" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                        @error('category_image')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <img width="40" class="my-2 d-block" src="{{ asset('backend/uploads/category_image') }}/{{ $cat_info->category_image }}" id="blah" alt="">


                        <input type="hidden" name="cat_id" value="{{ $cat_info->id }}" >

                        <button type="submit" class="btn btn-info mt-3" >Add Category</button>

                    </form>
                </div>
            </div>
        </div>
    </div>




    @endsection
