@extends('admin.layouts.master')

@section('title') {{$page_title}} @endsection

@section('css')
    <!-- datatables css -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        #map {
            height: 200px;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            /* margin-left: 12px; */
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 100%;
            height: 35px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }
    </style>
@endsection

@section('content')
    <!-- start page title -->
    <div class="row align-items-center">
        <div class="col">
            <div class="page-title-box">
                <h4 class="font-size-18">{{$page_title}}</h4>
                <ol class="breadcrumb mb-0">
                    {{ Breadcrumbs::render('creativers_form') }}
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
                                    <a href="{{route('admin.creativers')}}" class="btn btn-danger waves-effect waves-light">Back</a>
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
                                    <label>Description</label>
                                    <div>
                                        <textarea name="description" class="form-control" cols="30" rows="5" required placeholder="Enter Description" {{ $type == 'Detail' ? 'disabled' : null }}>{{@$data['description']}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Category</label>
                                    <div>
                                        <select name="category_id" class="form-control filter-field select-category" required {{ $type == 'Detail' ? 'disabled' : null }}></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Photo</label>
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
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Province</label>
                                    <div>
                                        <select name="province_id" class="form-control filter-field select-province" required {{ $type == 'Detail' ? 'disabled' : null }}></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>City</label>
                                    <div>
                                        <select name="city_id" class="form-control filter-field select-city" required {{ $type == 'Detail' ? 'disabled' : null }}></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>District</label>
                                    <div>
                                        <select name="district_id" class="form-control filter-field select-district" required {{ $type == 'Detail' ? 'disabled' : null }}></select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <div>
                                        <input type="number" name="postal_code" class="form-control" required
                                            placeholder="Enter Postal Code" value="{{@$data['postal_code']}}" {{ $type == 'Detail' ? 'readonly' : null }} />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Address</label>
                                    <div>
                                        @if($type!='Detail')
                                            <input id="pac-input" class="controls" type="text" placeholder="Search Box">
                                        @endif
                                        <div id="map"></div>
                                        <input type="hidden" name="latitude" id="latitude" value="{{@$data['latitude']}}">
                                        <input type="hidden" name="longitude" id="longitude" value="{{@$data['longitude']}}">
                                        <textarea type="text" id="address" class="form-control" name="address" required="" {{@$data->address == null ? 'disabled' : null}} {{$type!='Detail'?'':'readonly'}}>{{@$data->address}}</textarea>
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

    <script>
        var latitude = {{@$data->latitude}}
        var longitude = {{@$data->longitude}}

        let map;
        let city;
        let markers = [];
        let prevMarkers = [];
        
        function initMap() {
            const center = { lat: latitude != null ? latitude : -6.2293867, lng: longitude != null ? longitude : 106.6894301 };

            map = new google.maps.Map(document.getElementById("map"), {
                center: center,
                zoom: (latitude != null && longitude != null) ? 15 : 10,
            });

            if(latitude != null && longitude != null){
                const marker = new google.maps.Marker({
                    position: center,
                    map: map,
                })
                prevMarkers.push(marker);
            }

            const input = document.getElementById("pac-input");
            const searchBox = new google.maps.places.SearchBox(input);

            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }
                // Clear out the old markers.
                clearMarkers(prevMarkers); 

                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                if (!place.geometry || !place.geometry.location) {
                    console.log("Returned place contains no geometry");
                    return;
                }

                $('#address').val(places[0].formatted_address)
                $('#address').removeAttr('disabled')
                $('#latitude').val(places[0].geometry.location.lat())
                $('#longitude').val(places[0].geometry.location.lng())

                const icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25),
                };

                const marker = new google.maps.Marker({
                    map,
                    title: place.name,
                    draggable:true,
                    position: place.geometry.location,
                })
                prevMarkers.push(marker);

                google.maps.event.addListener(marker, 'dragend', function() 
                {
                    geocodePosition(marker.getPosition());
                });

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
                });
                map.fitBounds(bounds);
            });
        }

        function geocodePosition(pos){
            geocoder = new google.maps.Geocoder();
            geocoder.geocode({
                latLng: pos
            }, function(results, status) 
                {
                    if (status == google.maps.GeocoderStatus.OK) 
                    {
                        $('#address').val(results[0].formatted_address)
                        $('#latitude').val(results[0].geometry.location.lat())
                        $('#longitude').val(results[0].geometry.location.lng())
                        $("#mapSearchInput").val(results[0].formatted_address);
                        $("#mapErrorMsg").hide(100);
                    } 
                    else 
                    {
                        $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
                    }
                }
            );
        }

        const clearMarkers = (markers) => {
            for (let m of markers) {
                m.setMap(null);
            }
        }

        $(document).ready(function() {
            var category = {!! json_encode($category) !!}
            var province = {!! json_encode($province) !!}

            initSelect2('.select-category', category).then((result) => {
                result.val("{{ $data->category_id }}").trigger('change');
            }); 

            initSelect2('.select-province', province).then((result) => {
                result.val("{{ $data->province_id }}").trigger('change');
                result.on('change', function(e) {
                    new Promise(resolve => {
                        // $('.select-city').select2('destroy');
                        $('.select-city').html('');
                        $('.select-district').html('');
                        resolve(null)
                    }).then(response => {
                        initSelect2('.select-city', null);
                        initSelect2('.select-district', null);
                    }) 
                })
                result.on('select2:select', function (e) {
                    var data = e.params.data;
                    $.ajax({
                    url : `{{ route('get-city') }}/${data.id}`,
                    dataType: 'json',
                    success: function(data) {
                        new Promise(resolve => {
                            $('.select-city').select2('destroy');
                                resolve(data)
                            }).then(response => {
                                initSelect2('.select-city', response);
                            }) 
                        }
                    })
                });
            });

            var city = {!! json_encode($city) !!}
            initSelect2('.select-city', city).then((result) => {
                result.val("{{ $data->city_id }}").trigger('change');
            });

            var district = {!! json_encode($district) !!}
                initSelect2('.select-district', district).then((result) => {
                result.val("{{ $data->district_id }}").trigger('change');
            });

            $('.select-city').on('select2:select', function (e) {
                var data = e.params.data;
                $.ajax({
                    url : `{{ route('get-district') }}/${data.id}`,
                    dataType: 'json',
                    success: function(data) {
                        new Promise(resolve => {
                            $('.select-district').select2('destroy');
                            $('.select-district').html('');
                            resolve(data)
                        }).then(response => {
                            initSelect2('.select-district', response);
                        }) 
                    }
                })
            });
        })
    </script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxJh_fDthfzpzKK7ClLoSFHe3M3VV27vk&callback=initMap&libraries=places&v=weekly"
      async
    ></script>

@endsection