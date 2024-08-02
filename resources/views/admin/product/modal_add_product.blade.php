<div class="modal fade" id="modal_add_product" tabindex="-1" role="dialog" aria-labelledby="modal_add_product" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Highlight Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="{{route('admin_hl_product_create')}}" method="post" data-parsley-validate>
                <input type="hidden" id="add_product_method" name="_method" value="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password">Product: *</label>
                                <select class="form-control" id="place_product_id" name="place_product_id" required>
                                    @foreach($placeproducts as $product)
                                    <option value="{{$product->id}}">{{$product->name}} / {{$product->place->name??'-'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submit_add_product">Add</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
