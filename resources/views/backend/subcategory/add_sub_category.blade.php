@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('add_sub_category') }}">Add Sub Category</a></li>
    </ol>



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
                    <h4>Add Sub Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('store_subcat') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <label>Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control my-1">
                        @error('subcategory_name')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <label> Select Category </label>
                        <select  id="" name="category_id" class="form-control my-1">
                            <option>--select a category--</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <label>Subategory Image</label>
                        <input type="file" name="subcategory_image" class="form-control my-1" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >
                        @error('subcategory_image')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <img width="40" class="my-2 d-block" src="" id="blah" >

                        <button type="submit" class="btn btn-info mt-3" >Add Sub Category</button>

                    </form>
                </div>
            </div>
        </div>
    </div>






@endsection



