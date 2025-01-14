@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>District</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <button class="btn btn-primary" id="btn_add_city" type="button">+ Add District</button>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Select Region:</label>
                            <form>
                                <select class="form-control" id="select_country_id" name="country_id" onchange="this.form.submit()">
                                    <option value="">--- Select region ---</option>
                                    @foreach($countries as $country)
                                        @if($country_id)
                                            <option value="{{$country->id}}" {{isSelected($country->id, $country_id)}}>{{$country->name}}</option>
                                        @else
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">
                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                        <tr>
                            <th width="3%">ID</th>
                            <th width="5%">Thumb</th>
                            <th width="5%">District Map-Hero</th>
                            <th width="5%">District Map-Tile</th>
                            <th width="12%">District Name</th>
                            <th width="13%">Region Name</th>
                            <th>Priority</th>
                            <th width="10%">Is Popular</th>
                            <th width="3%">Status</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($cities as $city)
                            <tr>
                                <td>{{$city->id}}</td>
                                <td><img class="city_list_img" src="{{getImageUrl($city->thumb)}}" alt="{{$city->slug}} thumb"></td>
                                <td><img class="city_list_img" src="{{getCitymapUrl($city->map)}}" alt="{{$city->slug}} map-hero"></td>
                                <td><img class="city_list_img" src="{{getCitymapUrl($city->map_tile)}}" alt="{{$city->slug}} map-tile"></td>
                                <td>{{$city->name}}</td>
                                <td>{{$city->country->name}}</td>
                                <td>{{$city->priority}}</td>
                                <td>
                                    <input type="checkbox" class="js-switch city_is_popular" data-id="{{$city->id}}" {{isChecked($city->is_popular, 1)}}/>
                                </td>
                                <td>
                                    <input type="checkbox" class="js-switch city_status" data-id="{{$city->id}}" {{isChecked($city->status, 1)}}/>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs city_edit"
                                            data-id="{{$city->id}}"
                                            data-countryid="{{$city->country_id}}"
                                            data-name="{{$city->name}}"
                                            data-slug="{{$city->slug}}"
                                            data-intro="{{$city->intro}}"
                                            data-description="{{$city->description}}"
                                            data-thumb="{{$city->thumb}}"
                                            data-banner="{{$city->banner}}"
                                            data-map ="{{$city->map}}"
                                            data-map_tile ="{{$city->map_tile}}"
                                            data-website = "{{$city->website}}"
                                            data-video = "{{$city->video}}"
                                            data-besttimetovisit="{{$city->best_time_to_visit}}"
                                            data-currency="{{$city->currency}}"
                                            data-language="{{$city->language}}"
                                            data-lat="{{$city->lat}}"
                                            data-lng="{{$city->lng}}"
                                            data-priority="{{$city->priority}}"
                                            data-translations="{{$city->translations}}"
                                            data-seotitle="{{$city->seo_title}}"
                                            data-seodescription="{{$city->seo_description}}"
                                            data-is_popular="{{$city->is_popular}}"
                                    >Edit
                                    </button>
                                    <form class="d-inline" action="{{route('admin_city_delete',$city->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-xs city_delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>

    @include('admin.city.modal_add_city')
@stop

@push('scripts')
    <script src="{{asset('admin/js/page_city.js')}}"></script>
@endpush
