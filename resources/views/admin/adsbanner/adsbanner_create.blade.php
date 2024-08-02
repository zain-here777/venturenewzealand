@extends('admin.layouts.template')

@section('main')
    <div class="page-title">
        <div class="title_left">
            @if(isRoute('admin_adsbanners_page_edit'))
                <h3>Edit Ads Banner</h3>
            @else
                <h3>Add Ads Banner</h3>
            @endif
        </div>
    </div>
    <div class="clearfix"></div>

    @php
        $adsbanner_image = $banner_id = '';
        if(isset($adsbanners)){
            $adsbanner_image  = $adsbanners->image;
            $banner_id = $adsbanners->id;
        }
    @endphp


    <div class="row">

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_title">
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <form class="" action="{{route('admin_adsbanners_action')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if(isRoute('admin_adsbanners_page_edit'))
                            @method('put')
                        @endif

                        <div class="tab-content">
                            <ul class="nav nav-tabs bar_tabs" role="tablist">
                                @foreach($languages as $index => $language)
                                    <li class="nav-item">
                                        <a class="nav-link {{$index !== 0 ?: "active"}}" id="home-tab" data-toggle="tab" href="#language_{{$language->code}}" role="tab" aria-controls="" aria-selected="">{{$language->name}}</a>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="tab-content">
                                        @foreach($languages as $index => $language)
                                            @php
                                                $trans = $adsbanners ? $adsbanners->translate($language->code) : [];
                                            @endphp
                                            <div class="tab-pane fade show {{$index !== 0 ?: "active"}}" id="language_{{$language->code}}" role="tabpanel" aria-labelledby="home-tab">
                                                <div class="form-group">
                                                    <label for="job_title">Title
                                                        <small>({{$language->code}})</small>
                                                        : *</label>
                                                    @if(isRoute('admin_adsbanners_page_add'))
                                                        <input type="text" class="form-control" id="title" name="{{$language->code}}[title]" placeholder="Enter title of banner" autocomplete="off">
                                                    @else
                                                        @php
                                                            if (!isset($trans['title']) || $trans['title'] == null ){
                                                                $trans_title = '';
                                                            } else {
                                                                $trans_title = $trans['title'];
                                                            }
                                                        @endphp
                                                        <input type="text" class="form-control" id="title" name="{{$language->code}}[title]" value="{{ $trans_title }}" placeholder="Enter title of banner" autocomplete="off">
                                                    @endif

                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label for="place_name">Avatar:</label>
                                        <br>
                                        @if($adsbanner_image)
                                            {{-- @php
                                                $begin_no = strpos($adsbanner_image, '><');
                                                $end_no = strrpos($adsbanner_image, '><');
                                                $len = $end_no - $begin_no;
                                                $img_str = substr($adsbanner_image, $begin_no + 1, $len);
                                                echo($img_str);
                                            @endphp --}}
                                            <input type="text" class="form-control" id="avatar" value="{{$adsbanner_image}}" name="image">
                                        @else
                                            {{-- <img id="preview_avatar" src="https://via.placeholder.com/150x150?text=thumbnail" style="width:150px; height: 150px;border-radius: 50%"> --}}
                                            <input type="text" class="form-control" id="avatar" name="image" required>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div>
                                @if(isRoute('admin_adsbanners_page_edit'))
                                    <input type="hidden" name="id" value="{{$banner_id}}">
                                    <button type="submit" class="btn btn-primary mt-20">Save</button>
                                @else
                                    <button type="submit" class="btn btn-primary mt-20">Add</button>
                                @endif
                            </div>

                        </div>
                    </form>

                </div>


            </div>
        </div>
    </div>

@stop

@push('scripts')
    {{-- <script>
        $('#avatar').change(function () {
            previewUploadImage(this, 'preview_avatar')
        });
    </script> --}}
@endpush

@push('style')
@endpush

