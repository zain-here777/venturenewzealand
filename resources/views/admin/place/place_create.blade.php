@extends('admin.layouts.template')
<link rel="stylesheet" href="{{asset('assets/select2/css/select2.min.css')}}">
@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>Place create</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="col-lg-3">
                        <ul class="nav nav-tabs tabs-left place_create_menu">
                            <li class=""><a href="#genaral">Genaral</a></li>
                            <li class=""><a href="#hightlight">Hightlight</a></li>
                            <li class=""><a href="#location">Location</a></li>
                            <li class=""><a href="#contact_info">Contact info</a></li>
                            <li class=""><a href="#social_network">Social network</a></li>
                            <li class=""><a href="#opening_hours">Open hourses</a></li>
                            <li class=""><a href="#menus">Products</a></li>
                            <li class=""><a href="#media">Media</a></li>
                            <li class=""><a href="#link_affiliate">Booking link</a></li>
                            <li class=""><a href="#golo_seo">{{env('APP_NAME')}} SEO</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-8 col-xs-12 place_create">
                        @if($place)
                            @include('admin.place.form_edit')
                        @else
                            @include('admin.place.form_create')
                        @endif
                    </div>
                    <div class="clearfix"></div>
                </div>

            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    @if(setting('map_service', 'google_map') === 'google_map')
        <script src="{{asset('admin/js/page_place_create.js')}}"></script>
    @else
        <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js'></script>
        <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css' rel='stylesheet' />
        <!-- Load the `mapbox-gl-geocoder` plugin. -->
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.min.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.2/mapbox-gl-geocoder.css" type="text/css">

        <!-- Promise polyfill script is required -->
        <!-- to use Mapbox GL Geocoder in IE 11. -->
        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoibWluaHRoZSIsImEiOiJja2phc2l1eWc0OHF1MnJtMGw3ZzFjeXdxIn0.mJAsm20swzej4lWDUBucow';
        </script>
        <script src="{{asset('admin/js/page_place_create_mapbox.js')}}"></script>
    @endif
    <script src="{{asset('assets/select2/js/select2.full.min.js')}}"></script>
    <script>
        $('.select2').select2()
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        let selectedValuesCount = $('#lis_category').val();
        console.log(selectedValuesCount)
        if(selectedValuesCount != null){
            getSubcategory();
        }
        $('#lis_category').on('change',function(){
            getSubcategory();
        });

        function getSubcategory() {
            let oldPlaceTypeSelected = '';
            if($('#lis_place_type').val()){
                oldPlaceTypeSelected = '['+ $('#lis_place_type').val()+ ']  ';
            }
            let selectedValues = $('#lis_category').val();
            if(selectedValues){
                $.ajax({
                    url: "{{ route('get_sub_category') }}",
                    type: "POST",
                    data: { category_ids : selectedValues },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result)
                    {
                        console.log(result);
                        if (result.status == true) {
                            let data = result.data;

                            let options = "";
                            $('#lis_place_type').empty();

                            // $.each(data, function(index,value){
                            //     options +=  '<optgroup label="'+value['name']+'">';
                            //     if(value['place_type'] !== ''){
                            //         value['place_type'].forEach(element => {

                            //             if(oldPlaceTypeSelected.indexOf(element.id) !== -1){
                            //                 options +=  '<option value="'+element.id+'" selected>'+element.name+'</option>';
                            //             }else{
                            //                 options +=  '<option value="'+element.id+'">'+element.name+'</option>';
                            //             }
                            //         });
                            //     }
                            //     options +=  '</optgroup>';
                            // });

                            data.map(function(data){
                                if(oldPlaceTypeSelected.indexOf(data.id) !== -1){
                                    options +=  '<option value="'+data.id+'" selected>'+data.name+'</option>';
                                }else{
                                    options +=  '<option value="'+data.id+'">'+data.name+'</option>';
                                }
                            })
                            $('#lis_place_type').append(options);
                            //$('#lis_place_type').trigger("chosen-select:updated");
                            $('#lis_place_type').trigger("chosen:updated");
                        }
                    },
                    error: function () {
                    }
                });
            }else{
                $('#lis_place_type').html('');
                $('#lis_place_type').val('');
                $('#lis_place_type').empty();
                $('#lis_place_type').append('');
                $('#lis_place_type').trigger("chosen:updated");
            }
        }
    });
    </script>
@endpush
