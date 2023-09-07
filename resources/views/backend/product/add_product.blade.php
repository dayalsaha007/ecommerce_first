@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('add_product') }}">Add New Product</a></li>
    </ol>

</nav>


<div class="row">

    <div class="col-md-12">

        @if (session('p_msg'))
            <div class="alert alert-primary">
                {{ session('p_msg')}}
            </div>
        @endif

        <form action="{{ route('product_store') }}" method="POST" enctype="multipart/form-data" >
            @csrf
            <div class="card">
                <div class="card-header">
                    <p>Add new Product</p>
                </div>
                <div class="card-body">
                    <div class="row">

                        <div class="col-lg-4 mb-2">
                            <label>Product Name</label>
                            <input type="text"  name="product_name" class="form-control" >
                        </div>
                        <div class="col-lg-4 mb-2">
                            <label>Product Price</label>
                            <input type="number"  name="price" class="form-control" >
                        </div>
                        <div class="col-lg-4 mb-2">
                            <label>Discount</label>
                            <input type="number"  name="discount" class="form-control " >
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Select Category</label>
                            <select name="category_id" id="category_id" class="form-control"id="">
                                <option value="">--select any--</option>

                                 @foreach ($category as $cat)
                                     <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                 @endforeach


                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Select Sub Category</label>
                            <select name="subcategory_id" id="subcategory_id" class="form-control"id="">
                                <option value="">--select any--</option>

                                 @foreach ($subcategory as $sub_cat)
                                     <option value="{{ $sub_cat->id }}">{{ $sub_cat->subcategory_name }}</option>
                                 @endforeach

                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Product Brand</label>

                            <select name="brand_id"  class="form-control">
                                <option value="">--select any--</option>

                                 @foreach ($brands as $brand)
                                     <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                 @endforeach

                            </select>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Short Description</label>
                            <input type="text"  name="short_desp" class="form-control" >
                        </div>

                        <div class="col-lg-12 mb-2">
                            <label>Long Description</label>
                            <textarea class="form-control" name="long_desp"  cols="30" rows="5"></textarea>

                        </div>

                        <div class="col-lg-12 mb-2">
                            <label>Aditional Information</label>
                            <textarea class="form-control" name="add_info"  cols="30" rows="5"></textarea>
                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Preview</label>
                           <input type="file" class="form-control" name="preview"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" >

                           <img width="40" class="my-2 d-block" src="" id="blah" >

                        </div>

                        <div class="col-lg-6 mb-2">
                            <label>Gallery</label>
                            <input type="file" class="form-control"  multiple name="gallery[]"  onchange="document.getElementById('slah').src = window.URL.createObjectURL(this.files[0])">
                            <img width="40" class="my-2 d-block" src="" id="slah" >
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

@section('footer_script')

  <script>
          $('#category_id').change(function(){
            var category_id = $(this).val();


            $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                type:'post',
                url:'/getsubcategory',
                data:{'category_id' :category_id},
                success:function(data){
                    $('#subcategory_id').html(data)
                }
                });

          });
  </script>

@endsection
