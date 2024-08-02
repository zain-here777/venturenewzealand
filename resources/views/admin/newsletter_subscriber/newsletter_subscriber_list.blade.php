@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            <h3>Newsletter Subscribers</h3>
        </div>
        
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table class="table table-striped table-bordered" id="tableSubscribers">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <!-- <th>Status</th> -->
                            <!-- <th>Action</th> -->
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newsletterSubscribers as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->email}}</td>
                                <td>
                                    <form class="d-inline"
                                        action="{{ route('admin_newsletter_subscribers_destroy', $row->id) }}"
                                        method="POST">
                                        @method('DELETE')
                                        @csrf
                                        <button type="button" class="btn btn-danger btn-xs city_delete"
                                            onclick="if(confirm('Are you sure? The subscriber that deleted can not restore!')) $(this).parent().submit();">Delete</button>
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

@stop

@push('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />
@endpush

@push('scripts')
<script src="{{asset('admin/js/page_category.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {
    $('#tableSubscribers').DataTable({
        "pageLength": 10,
        "order": [0, "desc"],
        dom: "<'row'<'col-sm-6'l><'col-sm-3'B><'col-sm-3'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'csv', 'excel', 'pdf', 'print'
        ]
    });
});
</script>
@endpush
