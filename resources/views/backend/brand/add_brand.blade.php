@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('add_brands') }}">Add New Brand</a></li>
    </ol>

</nav>


    <div class="row">
        <div class="col-lg-6">
            @if (session('b_msg'))
                <div class="alert alert-primary">
                    {{ session('b_msg') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3>Add Brand</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('insert_brands') }}" method="POST" enctype="multipart/form-data" >
                        @csrf

                        <label class="my-2" >Brand Name</label>
                        <input type="text" name="brand_name" class="form-control ">

                        <label  class="my-2">Brand Image</label>
                        <input type="file" name="brand_image" class="form-control">

                        <button type="submit" class="btn btn-primary mt-3" >Add Brand</button>

                    </form>
                </div>
            </div>
        </div>
    </div>






@endsection
