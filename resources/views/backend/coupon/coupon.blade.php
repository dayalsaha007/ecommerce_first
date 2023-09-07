@extends('backend.master_dashboard')

@section('content')
<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('add_category') }}">Coupon</a></li>
    </ol>

</nav>

<div class="row">
    <div class="col-lg-8">

        <div class="card">
            <div class="card-header">
                <h3>Coupon list</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Coupon Name</th>
                            <th>type</th>
                            <th>Amount</th>
                            <th>Expire Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->coupon_name }}</td>
                                <td>{{ $coupon->type==1?'percentage':'fixed' }}</td>
                                <td>{{ $coupon->amount }}</td>
                                <td>
                                    {{ Carbon\Carbon::now()->diffInDays($coupon->expire_date, false) }} days remaining</td>
                                <td>
                                    <a href="" class="btn btn-sm btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add new Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('coupon_store') }}" method="POST">
                    @csrf
                    <div class="my-1">
                        <label >Coupon Name</label>
                        <input type="text" name="coupon_name" class="form-control" >
                    </div>

                    <div class="my-1">
                        <label >Type</label>
                        <select name="type" class="form-control" id="">
                            <option >-selectone-</option>
                            <option value="1" >percentage</option>
                            <option value="2" >fixed</option>
                        </select>
                    </div>
                    <div class="my-1">
                        <label >Amount</label>
                        <input type="text" name="amount" class="form-control" >
                    </div>
                    <div class="my-1">
                        <label >Expire Date</label>
                        <input type="date" name="expire_date" class="form-control" >
                    </div>
                    <div class="my-1">
                        <button class="btn btn-info" >Add Coupons</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>


@endsection
