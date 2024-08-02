@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>Interests</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <button class="btn btn-primary" id="btn_add_interest" type="button">+ Add interest</button>
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
                            <label>Select Category:</label>
                            <form>
                                <select class="form-control" id="select_category_id" name="category_id" onchange="this.form.submit()">
                                    <option value="">--- Select Category ---</option>
                                    @foreach($categories as $category)
                                        @if($category_id)
                                            <option value="{{$category->id}}" {{isSelected($category->id, $category_id)}}>{{$category->name}}</option>
                                        @else
                                            <option value="{{$category->id}}">{{$category->name}}</option>
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
                            <th>ID</th>
                            <th>Category</th>
                            <th>Interest Keyword</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($interests as $interest)
                            <tr>
                                <td>{{$interest->id}}</td>
                                <td>{{$interest->category->name}}</td>
                                <td>{{$interest->keyword}}</td>
                                <td>
                                    <form class="d-inline" action="{{route('admin_interest_delete',$interest->id)}}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-xs interest_delete">Delete</button>
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

    @include('admin.interest.modal_add_interest')
@stop

@push('scripts')
    <script src="{{asset('admin/js/page_interest.js')}}"></script>
@endpush
