@extends('admin.layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('blogs') }}
                </ol>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                <div class="row mb-3">
                    <div class="col">
                        <h4 class="card-title">List {{$page_title}}</h4>
                    </div>

                    <div class="col text-right">
                        <button type="button" data-toggle="modal" data-target="#modal-filter" class="btn btn-warning">Filter</button>
                        <a href="{{route('admin.blogs.form')}}" class="btn btn-primary dropdown-toggle waves-effect waves-light">
                            New
                        </a>
                    </div>

                </div>

                    @include('admin.layouts.table', ['header' => $table_header])

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @include('admin.layouts.filter', ['filter' => json_decode($setFilter, true)])

@endsection


@section('script')
    <script type="text/javascript">
        var TOKEN = '{{csrf_token()}}';
        var filter = JSON.parse("{{$setFilter}}".replace(/&quot;/g,'"'))
        var oTable;
        $(document).ready(function() {
            oTable = $('#dt_table').dataTable({
                pageLength: 10,
                responsive: true,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                dom: 'lrtip',
                order: [[ 4, "desc" ]],
                processing: true,
                serverSide: true,
                language: { 
                paginate: {
                    previous: "<i class='fas fa-angle-left'>",
                    next: "<i class='fas fa-angle-right'>"
                }
                },
                ajax: {
                    url: "{{ route('admin.blogs') }}",
                    dataType: "json",
                    type: "GET",
                    data: function ( d ) {
                        oSearch = {};
                        $('.filter-field').each( function () {
                            key = $(this).attr('name');
                            val = $(this).val();
                            oSearch[key] = val;
                        });
                        return $.extend(false, TOKEN, {page : page}, oSearch, d);
                    }
                },
                preDrawCallback: function( settings ) {
                    var api = this.api();
                    page = parseInt(api.rows().page()) + 1;
                },
                columns: [
                    {data : 'rownum'},
                    {data : 'title'},
                    {data : 'short_description'},
                    {data : 'is_public'},
                    {data : 'created_at'},
                    {data : 'action'},
                ],
                columnDefs: [{
                    targets: 2,
                    className: "dt-longtext"
                }],
            });

            $('.filter-btn').on('click', function(){
                oTable.api().draw();
            }); 

            $('.filter-clean').on('click', function(){
                $('.filter-field').val(null).trigger('change');
                oTable.api().draw();
            });
        });
    </script>
@endsection
