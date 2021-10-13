@section('css')
    <!-- datatables css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

<div class="modal fade" id="modal-filter" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modal-filter" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">

                    @foreach($filter as $key => $row)

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>{{$row['title']}}</label><br>

                                @if($row['type'] == 'select')
                                    <select placeholder="Search Name" name="search[{{$row['name']}}]" class="form-control filter-field {{$row['class']}}"></select>
                                @else
                                    <input type="{{$row['type']}}" name="search[{{$row['name']}}]" class="form-control filter-field {{$row['class']}}" placeholder="{{$row['title']}}">
                                @endif
                            </div>
                        </div>

                    @endforeach

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger filter-btn">Filter</button>
                <button type="button" class="btn btn-primary filter-clean">Clear</button>
                <button type="button" class="btn btn-light  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@section('script')
@parent
<script type="text/javascript">
  
  $(document).ready(function(){

    $('.date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose : true,
      clearBtn: true
    })

    filter.map(v => {
      if(v.type == 'select'){
        initSelect2('.'+v.class, v.data)
      }
    })
  });
</script>
@stop