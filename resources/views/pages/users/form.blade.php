@extends('admin.layouts.master')

@section('title') {{$page_title}} @endsection

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
                                    <a href="{{route('admin.users')}}" class="btn btn-danger waves-effect waves-light">Back</a>
                                    @if($type != 'Detail')
                                        <input type="submit" class="btn btn-primary ml-1" value="Submit">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" required
                                            placeholder="Enter Name" value="{{@$data['name']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Phone</label>
                                    <div>
                                        <input type="number" name="phone" class="form-control" min="0" required
                                            placeholder="Enter Phone" value="{{@$data['phone']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <div>
                                        <input type="text" name="email" class="form-control" required
                                            placeholder="Enter Email" value="{{@$data['email']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Username</label>
                                    <div>
                                        <input type="text" name="username" class="form-control" required
                                            placeholder="Enter Username" value="{{@$data['username']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Photo</label>
                                    <div>

                                        @if($type != 'Detail')

                                            <div class="custom-file">
                                                <input name="photo" type="file" class="custom-file-input" id="photo" accept="image/*">
                                                <label class="custom-file-label" for="inputGroupFile01">Select file</label>
                                            </div>

                                        @endif

                                        <div class="row mt-3" id="prev">
                                            <div class="col">
                                                <img src="{{URL::to(@$data['photo'] != null ? @$data['photo'] : '/assets/images/users/users.jpeg')}}" alt="" style="width:150px;border-radius: 5px;" id="previewThumbnail">
                                            </div>
                                        </div>
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