@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('all_sub_category') }}">All Sub Category</a></li>
    </ol>

        <div class="row">

                @if (session('sub_del'))
                    <div class="alert alert-danger">
                        {{ session('sub_del') }}
                    </div>
                @endif
                @if (session('sub_img_up'))
                    <div class="alert alert-primary">
                        {{ session('sub_img_up') }}
                    </div>
                @endif
                @if (session('sub_nm_up'))
                    <div class="alert alert-primary">
                        {{ session('sub_nm_up') }}
                    </div>
                @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Trashed Categories
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                        <tr>
                                            <th>Sr.no</th>
                                            <th>Subcate Name</th>
                                            <th>Cate Name</th>
                                            <th>Cate Img</th>
                                            <th>Action</th>
                                        </tr>
                                </thead>

                                <tbody>
                                    @foreach ($subcategories as $sub_cat)
                                        <tr>
                                            <td>{{ $loop->index }}</td>
                                            <td>{{ $sub_cat->subcategory_name }}</td>
                                            <td>{{ $sub_cat->category_name }}</td>
                                            <td><img width="40" src="{{ asset('backend/uploads/subcategory_image') }}/{{ $sub_cat->subcategory_image }}" alt=""></td>

                                            <td>


                            <a href="{{ route('edit_subcat', $sub_cat->id) }}" class="btn btn-primary"><i class="fa fa-pencil" ></i></a>

                            <a href="{{ route('delete_subcat', $sub_cat->id) }}" class="btn btn-warning"><i class="fa fa-trash-o" ></i></a>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>







@endsection
