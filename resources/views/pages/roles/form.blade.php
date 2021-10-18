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
                    {{ Breadcrumbs::render('roles_form') }}
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
                                    <a href="{{route('roles')}}" class="btn btn-danger waves-effect waves-light">Back</a>
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

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Display Name</label>
                                    <div>
                                        <input type="text" name="display_name" class="form-control" required
                                            placeholder="Enter Display Name" value="{{@$data['display_name']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Description</label>
                                    <div>
                                    <textarea name="description" class="form-control" cols="30" rows="5" required placeholder="Enter Description" {{ $type == 'Detail' ? 'disabled' : null }}>{{@$data['description']}}</textarea>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="card-title mb-3">Permissions</h4>
                            </div>
                            <div class="col-sm-6 text-right">
                                @if($type != 'Detail')
                                    <button type="button" class="btn btn-warning" onclick="unselect_all()"><i class="far fa-window-close"></i> Unselect All</button>
                                    <button type="button" class="btn btn-primary ml-1" onclick="select_all()"><i class="fa fa-check"></i> Select All</button>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                
                                <div class="row mt-5">

                                    @foreach($groups as $key => $row)

                                        <div class="col-md-6 col-lg-6 col-xxl-4 col-xs-12 col-sm-12 card {{$row}}" style="padding: 0 30px;">
                                            <div class="row mb-2">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <label class="font-weight-bolder" style="text-transform:capitalize;">{{$row}}</label>
                                                </div>
                                                <div class="col-md-6 col-sm-6 col-xs-12 text-md-right text-sm-right">
                                                    @if($type != 'Detail')
                                                        <span class="btn btn-warning" style="font-size: 10px;padding:3px;" onclick="unselect_group_all('{{$row}}')"><i class="far fa-window-close"></i> Unselect All</span>
                                                        <span class="btn btn-primary ml-1" style="font-size: 10px;padding:3px;" onclick="select_group_all('{{$row}}')"><i class="fa fa-check"></i> Select All</span>
                                                    @endif
                                                </div>
                                            </div>

                                            @foreach($permissions as $key_p => $row_p)

                                                @if(array_filter([$row_p->group == $row]))
                                            
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label style="font-weight:400;">{{$row_p->display_name}}</label>
                                                        </div>
                                                        <div class="col-6 text-right">
                                                            <input type="checkbox" name="permission_ids[]" value="{{ $row_p->id }}" 
                                                            {{ count($role_permissions) > 0 ? in_array($row_p->id, $role_permissions->toArray()) ? 'Checked' : '' : null}} onClick="{{ $type == 'Detail' ? 'return false' : null }}">
                                                        </div>
                                                    </div>

                                                @endif
                                                
                                            @endforeach
                                            <hr>
                                                
                                        </div>

                                    @endforeach

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

    <script>
        function select_all(){
            $('input[type="checkbox"]').each(function(){$(this).prop('checked',true)});
        }

        function unselect_all(){
            $('input[type="checkbox"]').each(function(){$(this).prop('checked',false)});
        }

        function select_group_all(group){
            $('.'+group+' input[type="checkbox"]').each(function(){$(this).prop('checked',true)});
        }

        function unselect_group_all(group){
            $('.'+group+' input[type="checkbox"]').each(function(){$(this).prop('checked',false)});
        }

        $(document).ready(function() {
        })
    </script>

@endsection