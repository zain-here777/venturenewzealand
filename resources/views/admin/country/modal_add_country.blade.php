<div class="modal fade" id="modal_add_country" tabindex="-1" role="dialog" aria-labelledby="modal_add_country" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add region</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form action="{{Request::fullUrl()}}" method="post" enctype="multipart/form-data" data-parsley-validate>
                <input type="hidden" id="add_country_method" name="_method" value="POST">
                @csrf

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="country_name">Region name: *</label>
                                <input type="text" class="form-control" id="country_name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="country_slug">Slug: *</label>
                                <input type="text" class="form-control" id="country_slug" name="slug" required>
                            </div>
                            <div class="form-group">
                                <label for="country_intro">Intro
                                    :</label>
                                <input type="text" class="form-control" id="country_description" name="description">
                            </div>
                            <div class="form-group">
                                <label for="country_about">Description
                                    :</label>
                                <textarea class="form-control" name="about" id="country_about" rows="5"></textarea>
                            </div>
                            <div class="row country_image">
                                <div class="col-md-3">
                                    <p><strong>Region Map-Hero:</strong></p>
                                    <img id="preview_map" src="https://via.placeholder.com/120x150?text=thumbnail" alt="Region Map">
                                    <input type="file" class="form-control" id="country_map" name="countrymap" accept="image/*">
                                </div>
                                <div class="col-md-3">
                                    <p><strong>Region Map-Tile:</strong></p>
                                    <img id="preview_map_tile" src="https://via.placeholder.com/120x150?text=thumbnail" alt="Region Map_tile">
                                    <input type="file" class="form-control" id="country_map_tile" name="countrymap_tile" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Banner image:</strong></p>
                                    <img id="preview_banner" src="https://via.placeholder.com/300x150?text=banner" alt="Country banner">
                                    <input type="file" class="form-control" id="country_banner" name="banner" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country_website">Website
                                    :</label>
                                <input type="text" class="form-control" id="country_website" name="website">
                            </div>
                            <div class="form-group">
                                <label for="country_video">Video
                                    :</label>
                                <input type="text" class="form-control" id="country_video" name="video">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="country_id" name="country_id" value="">
                    <button type="submit" class="btn btn-primary" id="submit_add_country">Add</button>
                    <button class="btn btn-primary" id="submit_edit_country">Save</button>
                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>
