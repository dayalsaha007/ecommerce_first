@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('all_category') }}">All Category</a></li>
    </ol>
    @if (session('p_del'))
    <div class="alert alert-primary">
        {{ session('p_del') }}
    </div>
    @endif
    @if (session('cname'))
    <div class="alert alert-primary">
            {{ session('cname') }}
    </div>
    @endif
    @if (session('r_cat'))
    <div class="alert alert-primary">
            {{ session('r_cat') }}
    </div>
    @endif
    @if (session('cimg'))
    <div class="alert alert-primary">
        {{ session('cimg') }}
    </div>
    @endif
    @if (session('del_cat'))
    <div class="alert alert-primary">
        {{ session('del_cat') }}
    </div>
    @endif
    <div class="row">

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    All Categories
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                    <tr>
                                        <th>Sr.no</th>
                                        <th>Cate Name</th>
                                        <th>Cate Img</th>
                                        <th>Subcat Count</th>
                                        <th>Action</th>
                                    </tr>
                            </thead>

                            <tbody>
                                @foreach ($categories as $cat)
                                    <tr>
                                        <td>{{ $loop->index }}</td>
                                        <td>{{ $cat->category_name }}</td>
                                        <td><img width="40" src="{{ asset('backend/uploads/category_image') }}/{{ $cat->category_image }}" alt=""></td>
                                        <td>{{ $cat->subcategory_count }}</td>
                                        <td>
                                            <a href="{{ route('edit_cat', $cat->id) }}" class="btn btn-primary"><i class="fa fa-pencil" ></i></a>

                                            <a href="{{ route('delete_cat', $cat->id) }}" class="btn btn-warning"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


            @if ($trashed_cat->count() >= 1)

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
                                                <th>Cate Name</th>
                                                <th>Cate Img</th>

                                                <th>Action</th>
                                            </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($trashed_cat as $cat)
                                            <tr>
                                                <td>{{ $loop->index }}</td>
                                                <td>{{ $cat->category_name }}</td>
                                                <td><img width="40" src="{{ asset('backend/uploads/category_image') }}/{{ $cat->category_image }}" alt=""></td>

                                                <td>


                                <a href="{{ route('restore_cat', $cat->id) }}" class="btn btn-warning"><i class="fa fa-superpowers" ></i></a>

                                <a href="{{ route('permanent_del', $cat->id) }}" class="btn btn-warning"><i class="fa fa-trash-o" ></i></a>


                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



            @endif

    </div>






@endsection
