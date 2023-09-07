@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>

    </ol>
</nav>


<div class="row">
    <div class="col-md-7">
            <div class="card">
                <div class="card-header"></div>
                <div class="card-body">
                    <table class="table table-bordered" >
                            <tr>
                                <th>Color</th>
                                <th>size</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                           @foreach ($inventories as $inventory)
                             <tr>
                                 <td>{{ $inventory->color_id == null?'NA':$inventory->rel_to_color->color_name }}</td>
                                 <td>{{ $inventory->size_id == null?'NA':$inventory->rel_to_size->size_name }}</td>
                                 <td>{{ $inventory->quantity }}</td>
                                 <td><a href="" class="btn-sm btn-danger" ><i class="fa fa-trash" ></i></a></td>
                             </tr>
                           @endforeach
                    </table>
                </div>
            </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                    <form action="{{ route('store_inventory') }}" method="POST" >
                        @csrf

                            <label>Product Name</label>
                            <input type="text" readonly value="{{ $product_info->product_name }}" name="product_name" class="form-control my-2" >

                            <input type="hidden" name="product_id" value="{{ $product_info->id }}" >

                            <label>Product Color</label>
                            <select name="color_id" class="form-control my-2">
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                                @endforeach
                            </select>

                            <label>Product Size</label>
                            <select name="size_id" class="form-control my-2">
                                <option value="31">NA</option>
                                @foreach ($sizes as $size)
                                    <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                                @endforeach
                            </select>

                            <label>Product Quantity</label>
                            <input type="number" name="quantity" class="form-control my-2" >

                            <button class="btn btn-primary my-2" >Add Inventory</button>

                    </form>
            </div>
        </div>
    </div>
</div>








@endsection
