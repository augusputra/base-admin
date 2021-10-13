@extends('layouts.master-without-nav')

@section('title') Login @endsection

@section('body')
    <body>
@endsection

@section('content')
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Welcome Back !</h5>
                                <p class="text-white-50">Sign in to continue.</p>
                                <a href="" class="logo logo-admin">
                                    <img src="assets/images/logo-sm.png" height="24" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                            <form class="form-horizontal mt-4" method="POST" action="">
                                @if(!empty(@Session::get('flash_message')))
                                    <div class="mb-10 alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        @if(is_array(@Session::get('flash_message'))) 
                                            {{join(", ",@Session::get('flash_message'))}}
                                        @else
                                            {{@Session::get('flash_message')}}
                                        @endif

                                        @php
                                            @Session::forget('flash_message');
                                        @endphp
                                    </div>
                                @endif
                                @csrf
                                    <div class="form-group">
                                        <label for="username">Email</label>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" @if(old('email')) value="{{ old('email') }}" @else value="" @endif  id="username" placeholder="Enter email" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword" value="" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group mt-2 mb-0 row">
                                        <div class="col-12 mt-4">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}"> <i class="mdi mdi-lock"></i>
                                                    Forgot your password?
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Veltrix. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection