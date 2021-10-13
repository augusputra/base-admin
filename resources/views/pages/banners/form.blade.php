@extends('admin.layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('banners_form') }}
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
                                    <a href="{{route('admin.banners')}}" class="btn btn-danger waves-effect waves-light">Back</a>
                                    @if($type != 'Detail')
                                        <input type="submit" class="btn btn-primary ml-1" value="Submit">
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Title</label>
                            <div>
                                <input type="text" name="title" class="form-control" required
                                    placeholder="Enter Title" value="{{@$data['title']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <div>
                                <textarea name="description" class="form-control" cols="30" rows="5" required placeholder="Enter Description" {{ $type == 'Detail' ? 'disabled' : null }}>{{@$data['description']}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Is Public</label>
                            <div>
                            <input name="is_public" type="checkbox" id="switch1" switch="none" {{@$data['is_public'] == 1 ? 'checked' : null}} {{ $type == 'Detail' ? 'disabled' : null }} />
                            <label for="switch1" data-on-label="On" data-off-label="Off"></label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Thumbnail</label>
                            <div>

                                @if($type != 'Detail')

                                    <div class="custom-file">
                                        <input name="thumbnail" type="file" class="custom-file-input" id="photo" accept="image/*">
                                        <label class="custom-file-label" for="inputGroupFile01">Select file</label>
                                    </div>

                                @endif

                                <div class="row mt-3" id="prev">
                                    <div class="col">
                                        <img src="{{URL::to(@$data['thumbnail'] != null ? @$data['thumbnail'] : '/assets/images/blogs.jpg')}}" alt="" style="width:50%;border-radius: 5px;" id="previewThumbnail">
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