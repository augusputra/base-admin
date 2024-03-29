@extends('layouts.master')

@section('title') {{$page_title}} @endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col-sm-12">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('roles') }}
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
                        
                        @can('create-role')
                            <a href="{{route('roles.form')}}" class="btn btn-primary dropdown-toggle waves-effect waves-light">
                                New
                            </a>
                        @endcan

                    </div>

                </div>

                    @include('layouts.table', ['header' => $table_header])

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

    @include('layouts.filter', ['filter' => json_decode($setFilter, true)])

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
                dom: 'Blrtip',
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
                    url: "{{ route('roles') }}",
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
                    {data : 'name'},
                    {data : 'display_name'},
                    {data : 'description'},
                    {data : 'created_at'},
                    {data : 'action'},
                ],
                buttons: [{
                    extend: 'excelHtml5',
                    className: "buttonsToHide",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        title: '{{$page_title}} report Export ~ ' + new Date(Date.now()).toGMTString(),
                    },
                    {
                        extend: 'csvHtml5',
                        className: "buttonsToHide",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5]
                        },
                        title: '{{$page_title}} report Export ~ ' + new Date(Date.now()).toGMTString(),
                    },
                    {
                        extend: 'pdfHtml5',
                        className: "buttonsToHide",
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5],
                        },
                        title: '{{$page_title}} report Export ~ ' + new Date(Date.now()).toGMTString(),
                    },
                ],
                columnDefs: [{
                    targets: 3,
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

            $(".buttonsToHide").css("display", "none");
    
            $('#export_excel').on('click', function(e) {
                e.preventDefault();
                $(".buttons-excel").click();
            });
    
            $('#export_csv').on('click', function(e) {
                e.preventDefault();
                $(".buttons-csv").click();
            });
    
            $('#export_pdf').on('click', function(e) {
                e.preventDefault();
                $(".buttons-pdf").click();
            });
        });

    </script>
@endsection
