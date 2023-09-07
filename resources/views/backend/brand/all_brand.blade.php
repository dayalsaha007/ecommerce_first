@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('all_brands') }}">All  Brands</a></li>
    </ol>

</nav>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Brand List</h3>
                    </div>
                    <div class="card-body">
                            <table class="table bordered" >
                                    <tr>
                                        <th>Brand Name</th>
                                        <th>Brand Image</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($brand as $item)
                                        <tr>
                                            <td>{{ $item->brand_name }}</td>
                                            <td><img width="50" src="{{ asset('backend/uploads/brand_image') }}/{{ $item->brand_image }}" ></td>
                                            <td>
                                                <a href="" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                    </div>
                </div>
            </div>
        </div>







@endsection
