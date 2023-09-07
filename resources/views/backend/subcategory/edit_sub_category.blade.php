@extends('backend.master_dashboard')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item" ><a href="{{ route('all_sub_category') }}">All Sub Category</a></li>
</ol>


    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Add Sub Category</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('update_subcat') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <label>Subcategory Name</label>
                        <input type="text" name="subcategory_name" value="{{ $sub_cat->subcategory_name }}" class="form-control my-1">
                        @error('subcategory_name')
                            <p class="text-danger" >{{ $message }}</p>
                        @enderror

                        <label> Select Category </label>
                        <select  id="" name="category_id" class="form-control my-1">
                            <option>--select a category--</option>
                            @foreach ($cat as $cate)
                                <option {{ $cate->id == $sub_cat->category_id? 'selected':'' }} value="{{ $cate->id }}">{{ $cate->category_name }}</option>
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

                        <img width="40" class="my-2 d-block" src="{{ asset('backend/uploads/subcategory_image') }}/{{ $sub_cat->subcategory_image }}" id="blah" >

                        <input type="hidden" name="subcategory_id" value="{{ $sub_cat->id }}" >

                        <button type="submit" class="btn btn-info mt-3" >Update Sub Category</button>

                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection
