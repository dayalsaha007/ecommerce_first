@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('all_product') }}">All Product</a></li>
    </ol>

</nav>



<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3>All Products</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive" >
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>Af Discount</th>
                            <th>Preview</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>&#2547; {{ $product->price }}</td>
                                <td>{{ $product->discount }}</td>
                                <td>&#2547; {{ $product->after_discount }}</td>
                                <td>
                                    <img width="50" src="{{ asset('backend/uploads/preview') }}/{{ $product->preview }}" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('product_inventory', $product->id) }}" class=" btn-sm btn-info" ><i class="fa fa-plus" ></i></a>
                                    <a href="{{ route('edit_product', $product->id) }}" class="btn-sm btn-primary" ><i class="fa fa-pencil-square-o" ></i></a>
                                    <a href="" class="btn-sm btn-danger" ><i class="fa fa-trash" ></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>







@endsection
