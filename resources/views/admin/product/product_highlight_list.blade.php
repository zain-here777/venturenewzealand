@extends('admin.layouts.template')

@section('main')

<div class="page-title">
    <div class="title_left">
        <h3>Highlighted Product</h3>
    </div>
    <div class="title_right">
        <div class="pull-right">
            <button class="btn btn-primary" id="btn_add_product" type="button">+ Add Highlighted Product</button>
        </div>
    </div>
</div>
<div class="clearfix">
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
        @if($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>:message</div>')) !!}
        @endif
</div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">
                <table class="table table-striped table-bordered golo-datatable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th style="width:40%">Product Name</th>
                            <th style="width:40%">Place Name</th>
                            <th style="width:10%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->product->name??'-'}}</td>
                            <td>{{$product->product->place->name??'-'}}</td>
                            <td>
                                <form class="d-inline" action="{{route('admin_hl_product_delete',$product->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="button" class="btn btn-danger btn-xs hi_product_delete">Delete</button>
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

@include('admin.product.modal_add_product')
@stop

@push('scripts')
<script>
    $(document).on("click", ".hi_product_delete", function() {
        if (confirm('Are you sure? The region that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $('#btn_add_product').click(function() {
        $('#submit_add_product').show();
        $('#add_product_method').val('POST');
        $('#place_product_id').val('');
        $('#modal_add_product').modal('show');
    });
</script>
@endpush
