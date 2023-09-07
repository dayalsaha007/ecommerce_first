@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href=""></a></li>
    </ol>

</nav>


<div class="row">

    <div class="col-md-12">



        <form action="{{ route('update_product') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card">
                <div class="card-header">
                    <p>Edit Product</p>
                </div>
                <div class="card-body">
                    <div class="row">

                        <input type="hidden" name="product_id" value={{ $product_info->id }} >
                        <div class="col-lg-4 mb-2">
                            <label>Product Name</label>
                            <input type="text"  name="product_name" value="{{ $product_info->product_name }}" class="form-control" >
                        </div>
                        <div class="col-lg-4 mb-2">
                            <label>Product Price</label>
                            <input type="number"  name="price" value="{{ $product_info->price }}" class="form-control" >
                        </div>
                        <div class="col-lg-4 mb-2">
                            <label>Discount</label>
                            <input type="number" value="{{ $product_info->discount }}"  name="discount" class="form-control " >
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Select Category</label>
                            <select name="category_id" id="category_id" class="form-control"id="">
                                <option value="">--select any--</option>

                                 @foreach ($categories as $cat)
                                     <option {{ $cat->id == $product_info->category_id? 'selected':'' }}   value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                 @endforeach


                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Select Sub Category</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control"id="">
                                <option value="">--select any--</option>

                                 @foreach ($subcategories as $sub_cat)
                                     <option {{ $sub_cat->id == $product_info->subcategory_id? 'selected':'' }} value="{{ $sub_cat->id }}">{{ $sub_cat->subcategory_name }}</option>
                                 @endforeach

                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Product Brand</label>

                            <select name="brand_id"  class="form-control">
                                <option value="">--select any--</option>

                                 @foreach ($brands as $brand)
                                     <option {{ $brand->id == $product_info->brand? 'selected':'' }} value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                 @endforeach

                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Short Description</label>
                            <input type="text"  name="short_desp" value="{{ $product_info->short_desp }}" class="form-control" >
                        </div>

                        <div class="col-lg-12 mb-2">
                            <label>Long Description</label>
                            <textarea class="form-control" name="long_desp"  cols="30" rows="5">{{ $product_info->long_desp }}</textarea>

                        </div>

                        <div class="col-lg-12 mb-2">
                            <label>Aditional Information</label>
                            <textarea class="form-control" name="add_info"  cols="30" rows="5">{{ $product_info->add_info }}</textarea>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Preview</label>
                           <input type="file" class="form-control" name="preview"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >

                           <img width="70" class="my-2" src="{{ asset('backend/uploads/preview') }}/{{ $product_info->preview }}" id="blah" >

                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Gallery</label>
                            <input type="file" class="form-control"  multiple name="gallery[]"  onchange="document.getElementById('lah').src = window.URL.createObjectURL(this.files[0])">

                            <div class="my-2">
                                @foreach ($gallery_images as $gallerys)
                                <img width="100" src="{{ asset('backend/uploads/gallery') }}/{{ $gallerys->gallery }}"  id="lah" >
                              @endforeach
                            </div>

                        </div>

                            <div class="col-lg-4 float-left mt-2">
                                <button type="submit" class="btn btn-info " >Add New Product</button>
                            </div>

                    </div>
                </div>
            </div>

        </form>
    </div>

</div>






@endsection
