@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('css')
    <!-- datatables css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('users_form') }}
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <form action="{{$action}}" method="POST" enctype="multipart/form-data" id="form">

        @csrf

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title mb-3">{{$type}} {{$page_title}}</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                <div class="col-12 text-right">
                                    <a href="{{route('users')}}" class="btn btn-danger waves-effect waves-light">Back</a>
                                    @if($type != 'Detail')
                                        <input type="submit" class="btn btn-primary ml-1" value="Submit">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>First Name</label>
                                    <div>
                                        <input type="text" name="first_name" class="form-control" required
                                            placeholder="Enter First Name" value="{{@$data['first_name']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Last Name</label>
                                    <div>
                                        <input type="text" name="last_name" class="form-control" required
                                            placeholder="Enter Last Name" value="{{@$data['last_name']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <div>
                                        <input id="input-email" class="form-control input-mask" name="email"
                                            placeholder="Enter Email" value="{{@$data['email']}}" {{ $type == 'Detail' ? 'readonly' : null }} data-inputmask="'alias': 'email'">
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                @if($type == 'Insert')
                                
                                    <div class="form-group">
                                        <label>Password</label>
                                        <div>
                                            <input type="password" name="password" class="form-control" required
                                                placeholder="Enter Password" value="" {{ $type == 'Detail' ? 'readonly' : null }} />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <div>
                                            <input type="password" name="password_confirmation" class="form-control" required
                                                placeholder="Enter Confirm Password" value="" {{ $type == 'Detail' ? 'readonly' : null }} />
                                        </div>
                                    </div>

                                @endif

                                @if($type == 'Update')

                                    @can('change-user-password')

                                        <div class="form-group">
                                            <label>Password</label>
                                            <div>
                                                <input type="password" name="password" class="form-control"
                                                    placeholder="Enter Password" value="" {{ $type == 'Detail' ? 'readonly' : null }} />
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <div>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    placeholder="Enter Confirm Password" value="" {{ $type == 'Detail' ? 'readonly' : null }} />
                                            </div>
                                        </div>

                                    @endcan

                                @endif


                                <div class="form-group">
                                    <label>Role</label>
                                    <div>
                                        <select name="role_id" class="form-control filter-field select-role" required {{ $type == 'Detail' ? 'disabled' : null }}></select>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

        </row>

    </form>

@endsection

@section('script')

    <!-- form mask -->
    <script src="{{ URL::asset('/assets/libs/inputmask/inputmask.min.js') }}"></script>

    <!-- form mask js -->
    <script src="{{ URL::asset('/assets/js/pages/form-mask.init.js') }}"></script>

    <script>
        $(document).ready(function() {
            var role = {!! json_encode($role) !!}

            initSelect2('.select-role', role).then((result) => {
                result.val("{{ @$data->role_id }}").trigger('change');
            }); 
        })
    </script>

@endsection