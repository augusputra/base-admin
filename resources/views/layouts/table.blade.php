<table id="dt_table" class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>

            @if(is_array($header) || is_object($header))
                @foreach($header as $key => $row)
                
                <th>{{$row}}</th>

                @endforeach
            @endif
            
        </tr>
    </thead>
</table>