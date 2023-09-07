@extends('backend.master_dashboard')


@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('variation') }}">Variation</a></li>
    </ol>

</nav>


    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Color List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" >
                        <tr>
                            <th>Color Name</th>
                            <th>Color Code</th>
                            <th>Action</th>
                        </tr>

                       @foreach ($colors as $color)
                         <tr>
                             <td>{{ $color->color_name }}</td>
                             <td><span class="badge" style="background:{{ $color->color_code }}; color:transparent;" >primary</span></td>
                             <td>
                                <a href="{{ route('delete_color', $color->id) }}" class="btn-sm btn-danger" ><i class="fa fa-trash" ></i></a>
                             </td>
                         </tr>
                       @endforeach

                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Add Color</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('insert_color') }}" method="POST" >
                        @csrf

                        <label > Color name </label>
                        <input type="text" name="color_name" class="form-control my-2" >

                        <label > Color Code </label>
                        <input type="text" name="color_code" class="form-control my-2" >

                        <button type="submit"  class="btn btn-primary mt-3" >Add Color </button>

                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Size List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" >
                        <tr>
                            <th>Category Name</th>
                            <th>Size</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($sizes as $size)
                            <tr>
                                <td>{{ $size->category_id == null?'NA':$size->rel_to_cat->category_name }}</td>
                                <td>{{ $size->size_name }}</td>
                                <td>
                                    <a href="{{ route('delete_size', $size->id) }}" class="btn-sm btn-danger" ><i class="fa fa-trash" ></i></a>
                                </td>
                            </tr>
                        @endforeach



                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card ">
                <div class="card-header">
                    <h3>Add size</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('insert_size') }}" method="POST" >
                        @csrf


                        <label class="form-label" > Category </label>
                        <select name="category_id" class="form-control my-2" >
                            <option value="">Select One</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>

                        <label > Size </label>
                        <input type="text" name="size_name" class="form-control my-2" >

                        <button type="submit"  class="btn btn-primary mt-3" >Add Size </button>

                    </form>
                </div>
            </div>
        </div>
    </div>




@endsection
