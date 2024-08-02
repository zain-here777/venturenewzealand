@extends('admin.layouts.template')

@section('main')

    <div class="page-title">
        <div class="title_left">
            <h3>Regions</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <button class="btn btn-primary" id="btn_add_country" type="button">+ Add region</button>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                        <tr>
                            <th width="3%">ID</th>
                            <th width="10%">Region Name</th>
                            <th width="10%">Region Map-Hero</th>
                            <th width="10%">Region Map-Tile</th>
                            <th width="15%">Intro</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($countries as $country)
                            <tr>
                                <td>{{$country->id}}</td>
                                <td>{{$country->name}}</td>
                                <td><img class="country_list_img" src="{{asset('assets/images/countries/' . $country->countrymap) }}" alt="{{$country->slug}} map_hero"></td>
                                <td><img class="country_list_img" src="{{asset('assets/images/countries/' . $country->countrymap_tile) }}" alt="{{$country->slug}} map_tile"></td>
                                <td>
                                    @if (strlen($country->description) > 50)
                                        {{substr($country->description, 0, 50)}} ...
                                    @else
                                        {{$country->description}}
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning btn-xs country_edit"
                                            data-id = "{{$country->id}}"
                                            data-name = "{{$country->name}}"
                                            data-slug = "{{$country->slug}}"
                                            data-description = "{{$country->description}}"
                                            data-banner = "{{$country->banner}}"
                                            data-countrymap = "{{$country->countrymap}}"
                                            data-countrymap_tile = "{{$country->countrymap_tile}}"
                                            data-about = "{{$country->about}}"
                                            data-website = "{{$country->website}}"
                                            data-video = "{{$country->video}}"
                                    >Edit
                                    </button>
                                    <form class="d-inline" action="{{route('admin_region_delete',$country->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-xs country_delete">Delete</button>
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

    @include('admin.country.modal_add_country')
@stop

@push('scripts')
    <script src="{{asset('admin/js/page_country.js')}}"></script>
@endpush
