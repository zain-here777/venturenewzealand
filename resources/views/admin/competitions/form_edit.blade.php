<form action="{{route('admin_competition_update')}}" enctype="multipart/form-data" method="post">
    @method('put')
    @csrf
    <input type="hidden" name="competition_id" value="{{$competition->id}}">
    <div class="tab-content">


        <div id="genaral">

            <div class="form-group row">
                <div class="col-md-12">
                    <div class="tab-content">

                            <div class="tab-pane fade show active" id="language" role="tabpanel" aria-labelledby="home-tab">
                                <div class="form-group">
                                    <label for="place_name">Title: *</label>
                                    <input type="text" value="{{$competition->title}}" class="form-control" name="title" placeholder="Title of competition" autocomplete="off" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description: *</label>
                                    <textarea type="text" class="form-control" id="description" name="description" rows="6">{{$competition->description}}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="terms_and_conditions">Terms and Conditions: *</label>
                                    <textarea type="text" class="form-control tinymce_editor" id="terms_and_conditions" name="terms_and_conditions" rows="6">{{$competition->terms_and_conditions}}</textarea>
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div id="media">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Image:</strong></p>
                        <img id="pc_image" src="{{getImageUrl($competition->image)}}" height="150" width="120">
                        <input type="file" class="form-control" id="c_image" name="image" accept="image/*">
                    </div>
                </div>
            </div>

            <div id="media">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Background Image (1905 x 650) :</strong></p>
                        <img id="p_background_image" src="{{getImageUrl($competition->background_image)}}" height="150" width="120">
                        <input type="file" class="form-control" id="background_image" name="background_image" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="form-group col-md-6">
                    <label for="description">Entry Fee Points: *</label>
                    <input type="number" value="{{cleanDecimalZeros($competition->entry_fee_points)}}" class="form-control" name="entry_fee_points" placeholder="Entry Fee Points" autocomplete="off" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="description">Prize Points: *</label>
                    <input type="number" value="{{cleanDecimalZeros($competition->prize_points)}}" class="form-control" name="prize_points" placeholder="Prize Points" autocomplete="off" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="description">Start Date - End Date: *</label>
                    <input type="text" value="{{dateFormat($competition->start_date)}} - {{dateFormat($competition->end_date)}}" class="form-control" name="start_end_date" id="start_end_date" placeholder="Start Date - End Date" autocomplete="off" required>
                </div>

                <!-- <div class="form-group col-md-6">
                    <label for="description">Start Date: *</label>
                    <input type="text" value="{{ dateFormat($competition->start_date) }}" class="form-control" name="start_date" id="start_date" placeholder="Start Date" autocomplete="off" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="description">End Date: *</label>
                    <input type="text" value="{{ dateFormat($competition->end_date) }}" class="form-control" name="end_date" id="end_date" placeholder="End Date" autocomplete="off" required>
                </div> -->
            </div>

        </div>










    </div>

    <button type="submit" class="btn btn-primary mt-20">Submit</button>
</form>
