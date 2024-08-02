@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>Competition create</h3>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">

                    <div class="col-lg-6  place_create">
                        @if($competition)
                            @include('admin.competitions.form_edit')
                        @else
                            @include('admin.competitions.form_create')
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
        <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        <script>
            mapboxgl.accessToken = 'pk.eyJ1IjoibWluaHRoZSIsImEiOiJja2phc2l1eWc0OHF1MnJtMGw3ZzFjeXdxIn0.mJAsm20swzej4lWDUBucow';
        </script>
        <script src="{{asset('admin/js/page_place_create_mapbox.js')}}"></script>
    @endif

    <script>
        $('#c_image').change(function() {
            previewUploadImage(this, 'pc_image');
        });
        $('#background_image').change(function() {
            previewUploadImage(this, 'p_background_image');
        });

        $(document).ready(function () {
            var currentDate = moment().format("DD-MM-YYYY");

            $("#start_end_date").daterangepicker({
                "alwaysShowCalendars": true,
                "minDate": currentDate,
                autoApply: true,
                autoUpdateInput: true,
                drops: 'up',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            });
        })

        // $(document).ready(function () {
        //     var startDateEdit = $('#start_date').val();
        //     var endDateEdit = $('#end_date').val();

        //     $("#start_date").data('daterangepicker').setStartDate(startDateEdit ? startDateEdit : moment().format("DD-MM-YYYY"));
        //     $("#start_date").data('daterangepicker').setEndDate(endDateEdit ? endDateEdit : moment().format("DD-MM-YYYY"));
        //     $("#end_date").data('daterangepicker').setStartDate(startDateEdit ? startDateEdit : moment().format("DD-MM-YYYY"));
        //     $("#end_date").data('daterangepicker').setEndDate(endDateEdit ? endDateEdit : moment().format("DD-MM-YYYY"));
        // })

        // if($('#start_date, #end_date').length){

        //     var currentDate = moment().format("DD-MM-YYYY");

        //     $('#start_date, #end_date').daterangepicker({
        //         locale: {
        //             format: 'DD-MM-YYYY'
        //         },
        //         "alwaysShowCalendars": true,
        //         "minDate": currentDate,
        //         // "maxDate": moment().add('months', 1),
        //         autoApply: true,
        //         autoUpdateInput: false,
        //         drops: 'up',
        //     }, function(start, end, label) {

        //     // Lets update the fields manually this event fires on selection of range
        //     var selectedStartDate = start.format('DD-MM-YYYY'); // selected start
        //     var selectedEndDate = end.format('DD-MM-YYYY'); // selected end
        //     $checkinInput = $('#start_date');
        //     $checkoutInput = $('#end_date');

        //     // Updating Fields with selected dates
        //     $checkinInput.val(selectedStartDate);
        //     $checkoutInput.val(selectedEndDate);

        //     var checkOutPicker = $checkoutInput.data('daterangepicker');
        //     checkOutPicker.setStartDate(selectedStartDate);
        //     checkOutPicker.setEndDate(selectedEndDate);

        //     var checkInPicker = $checkinInput.data('daterangepicker');
        //     checkInPicker.setStartDate(selectedStartDate);
        //     checkInPicker.setEndDate(selectedEndDate);

        //     });

        // } // End Daterange Picker

        $('.only_digit').on('input', function (event) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    </script>
@endpush
