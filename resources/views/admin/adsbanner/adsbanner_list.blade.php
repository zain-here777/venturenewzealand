@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>Ads Banners</h3>
        </div>
        <div class="title_right">
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('admin_adsbanners_page_add') }}">+ Add new</a>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <div class="clearfix"></div>
                </div>


                <div class="x_content">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="bannerTbl">
                            <thead>
                                <tr class="headings">
                                    <th>ID</th>
                                    <th class="column-title">Image</th>
                                    <th class="column-title">Title</th>
                                    <th class="column-title">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($adsbanners)>0)
                                @foreach ($adsbanners as $adsbanner)
                                    <tr class="even pointer">
                                        <td>{{ $adsbanner['id'] }}</td>
                                        <td class="ads_banner-img">
                                            @if ($adsbanner['image'])
                                                {{-- <img src="{{ getImageUrl($adsbanner['image']) }}" alt="no avt"
                                                    style="width: 50px;height: 50px; border-radius: 50%"> --}}
                                                @php
                                                    $begin_no = strpos($adsbanner['image'], '><');
                                                    $end_no = strrpos($adsbanner['image'], '><');
                                                    $len = $end_no - $begin_no;
                                                    $img_str = substr($adsbanner['image'], $begin_no + 1, $len);
                                                    echo($img_str);
                                                @endphp
                                            @else
                                                <img src="https://via.placeholder.com/50x50?text=no avt" alt="no avt"
                                                    style="width: 50px;height: 50px; border-radius: 50%">
                                            @endif
                                        </td>
                                        @if ($adsbanner['title'] != null)
                                            <td>{{ $adsbanner['title'] }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>
                                            <a href="{{ route('admin_adsbanners_page_edit', $adsbanner['id']) }}"
                                                class="btn btn-warning btn-xs city_edit">Edit</a>
                                            <form class="d-inline"
                                                action="{{ route('admin_adsbanners_destroy', $adsbanner['id']) }}"
                                                method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="button" class="btn btn-danger btn-xs city_delete"
                                                    onclick="if(confirm('Are you sure? The banner that deleted can not restore!')) $(this).parent().submit();">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr><td colspan="4">No Banners.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>


                </div>


            </div>
        </div>
    </div>

@stop

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#bannerTbl').DataTable({
                //    'aoColumnDefs': [{
                //        'bSortable': false,
                //        'aTargets': [[-1],[-3]]
                // 	}]
                'order': [0, 'desc'],
                'columnDefs': [{
                    "targets": [1, 3],
                    "orderable": false
                }]
            });
        });
    </script>
@endpush

@push('style')
    <style>
        .table>tbody>tr>td {
            vertical-align: middle;
        }

    </style>
@endpush
