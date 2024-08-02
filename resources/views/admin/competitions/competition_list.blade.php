@extends('admin.layouts.template')

@section('main')

    <div class="page-title">
        <div class="title_left">
            <h3>Competitions</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{route('admin_competition_create_view')}}">+ Add Competition</a>
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
                            <th width="5%">Thumb</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th width="15%">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($competitions as $competition)
                            <tr>
                                <td>{{$competition->id}}</td>
                                <td><img class="place_list_thumb" src="{{getImageUrl($competition->image)}}" alt="image"></td>
                                <td>{{$competition->title}}</td>
                                <td>{{$competition->description}}</td>
                                <td>{{ dateFormat($competition->start_date) }}</td>
                                <td>{{ dateFormat($competition->end_date) }}</td>

                                <td class="golo-flex">
                                    <a class="btn btn-warning btn-xs place_edit" href="{{route('admin_competition_edit_view', $competition->id)}}">Edit</a>
                                    <form action="{{route('admin_competition_delete',$competition->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-xs place_delete">Delete</button>
                                    </form>
                                    <a class="btn btn-info btn-xs participants_list" href="{{route('admin_competition_participants_list',$competition->id)}}">Participants</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>


                </div>

            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script src="{{asset('admin/js/page_place.js')}}"></script>
@endpush
