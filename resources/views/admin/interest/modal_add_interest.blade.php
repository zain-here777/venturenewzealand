<div class="modal fade" id="modal_add_interest" tabindex="-1" role="dialog" aria-labelledby="modal_add_interest" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add interest</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>

            <form action="{{Request::fullUrl()}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                <input type="hidden" id="add_interest_method" name="_method" value="POST">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 interest_create">

                            <div class="form-group">
                                <label for="category">Category: *</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="interest_keyword">Keyword:</label>
                                <input type="text" class="form-control" id="keyword" name="keyword">
                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    {{-- <input type="hidden" id="interest_id" name="interest_id" value=""> --}}
                    <button class="btn btn-primary" id="submit_add_interest">Add</button>
                    {{-- <button class="btn btn-primary" id="submit_edit_interest">Save</button> --}}
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>
