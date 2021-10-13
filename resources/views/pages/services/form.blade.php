@extends('admin.layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('services_form') }}
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
                                    <a href="{{route('admin.services')}}" class="btn btn-danger waves-effect waves-light">Back</a>
                                    @if($type != 'Detail')
                                        <input type="submit" class="btn btn-primary ml-1" value="Submit">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Name</label>
                            <div>
                                <input type="text" name="name" class="form-control" required
                                    placeholder="Enter Name" value="{{@$data['name']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <div>
                                <textarea name="description" class="form-control" cols="30" rows="5" required placeholder="Enter Description" {{ $type == 'Detail' ? 'disabled' : null }}>{{@$data['description']}}</textarea>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->

        </row>

    </form>

@endsection