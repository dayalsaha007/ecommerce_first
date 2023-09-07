@extends('backend.master_dashboard')

@section('content')

<nav aria-label="breadcrumb" >
    <ol class="breadcrumb">
        <li class="breadcrumb-item" ><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{ route('orders') }}">Orders</a></li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Order List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <td>Order Id</td>
                            <td>Total</td>
                            <td>Order Date</td>
                            <td>payment Method</td>
                            <td>Status</td>
                            <td>Action</td>
                        </tr>

                       @foreach ($orders as $order)
                         <tr>
                             <td>{{ $order->id }}</td>
                             <td>{{ $order->total }}</td>
                             <td>{{ $order->created_at->diffForHumans() }}</td>
                             <td>
                            @if($order->payment_method == 1)
                                <div class="badge badge-primary" >Cash on delivery</div>
                            @elseif($order->payment_method == 2)
                            <div class="badge badge-primary">SSL Commerz</div>
                            @else
                            <div class="badge badge-primary">Stripe</div>
                            @endif
                            </td>

                    <td>

                        @php
                            if($order->status == 0){
                                echo '<span class="badge badge-primary" >Placed</span>';
                            }
                            elseif($order->status == 1){
                                echo '<span class="badge badge-primary" >Processing</span>';
                            }
                            elseif($order->status == 2){
                                echo '<span class="badge badge-primary" >Pick Up</span>';
                            }
                            elseif($order->status == 3){
                                echo '<span class="badge badge-primary" >Ready to Deliver</span>';
                            }
                            elseif($order->status == 4){
                                echo '<span class="badge badge-primary" >Deliver</span>';
                            }
                            else{
                                echo 'NA';
                            }
                        @endphp

                    </td>

                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                              Select
                            </button>
             <form action="{{ route('status_update') }}" method="POST">
                             @csrf

                                <ul class="dropdown-menu">
                                    <input type="hidden" name="order_id" value="{{$order->order_id }}">
                                    <li><button value="0" name="status" class="dropdown-item" >Placed</button></li>
                                    <li><button value="1" name="status" class="dropdown-item" >Processing</button></li>
                                    <li><button value="2" name="status" class="dropdown-item" >Pick Up</button></li>
                                    <li><button value="3" name="status" class="dropdown-item" >Ready to Deliver</button></li>
                                    <li><button value="4" name="status" class="dropdown-item" >Delivered</button></li>
                                  </ul>
                                </form>
                            </div>
                        </td>
                    </tr>
            @endforeach



                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
