@extends('frontend.master_frontend')



@section('content')

<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->

<!-- ======================= Login Detail ======================== -->
<section class="middle">
    <div class="container">
        <div class="row align-items-start justify-content-between">

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                @if (session('old'))
                    <div class="alert alert-danger">
                            <p>{{ session('old') }}</p>
                    </div>
                @endif
                @if (session('log'))
                    <div class="alert alert-danger">{{ session('log') }}</div>
                     @endif
                <div class="mb-3">
                    <h3>Login</h3>
                </div>
                <form action="{{ route('customer_login') }}" method="post" class="border p-3 rounded">
                    @csrf
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>

                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" placeholder="Password*">
                    </div>

                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="eltio_k2">
                                <a href="#">Lost Your Password?</a>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Login</button>
                    </div>
                </form>
            </div>

            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mfliud">
                <div class="mb-3">
                    <h3>Register</h3>
                </div>
            <form action="{{ route('customer_register') }}" method="POST" enctype="multipart/form-data"  class="border p-3 rounded">
                @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Full Name *</label>
                            <input type="text" name="name" class="form-control" placeholder="Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="text" name="email" class="form-control" placeholder="Email*">
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Password *</label>
                            <input type="password" name="password" class="form-control" placeholder="Password*">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Confirm Password *</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password*">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Create An Account</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>
<!-- ======================= Login End ======================== -->


@endsection
