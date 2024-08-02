@extends('frontend.layouts.template')
@section('main')
    <main id="main" class="site-main">
        <div class="site-content">
            <div class="member-menu mt-5">
                <div class="container">
                    @include('frontend.user.user_menu')
                </div>
            </div>
            <div class="container">
                <div class="member-place-wrap">
                    <div class="member-place-top flex-inline">
                        <!-- <h1>{{__('Place')}}</h1> -->
                    </div><!-- .member-place-top -->
                    @include('frontend.common.box-alert')
                    <div class="member-filter">
                        <div class="mf-left">

                        </div><!-- .mf-left -->
                        <div class="mf-right">
                            <form action="" class="site__search__form" method="GET">
                                <div class="site__search__field">
										<span class="site__search__icon">
											<i class="la la-search"></i>
										</span><!-- .site__search__icon -->
                                    <input class="site__search__input" type="text" name="keyword" value="{{$filter['keyword']}}" placeholder="{{__('Search')}}">
                                </div><!-- .search__input -->
                            </form><!-- .search__form -->
                        </div><!-- .mf-right -->
                    </div><!-- .member-filter -->
                    <table class="member-place-list table-responsive operator_table">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{__('ID')}}</th>
                            <th>{{__('Image')}}</th>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Status')}}</th>
                            <th>{{__('Date Of Join')}}</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($operatorlist))
                            @foreach($operatorlist as $operator)
                                <tr>
                                    <td data-title=""></td>
                                    <td data-title="ID">{{$operator->id}}</td>
                                    <td data-title="Image"><img src="{{getImageUrl($operator->avatar)}}" alt="{{$operator->name}}"></td>
                                    <td data-title="Name"><b>{{$operator->name}}</b></td>
                                    <td data-title="Email"><b>{{$operator->email}}</b></td>
                                    {{-- <td data-title="Status"><b>{{$operator->status}}</b></td> --}}
                                    <td>
                                        <input type="checkbox" class="js-switch user_status" data-id="{{$operator->id}}" {{isChecked($operator->status, \App\Models\User::STATUS_ACTIVE)}}/>
                                    </td>
                                    <td data-title="Email"><b>{{date('d/m/Y',strtotime($operator->created_at))}}</b></td>
                                </tr>
                            @endforeach
                        @else
                            {{__('No item found')}}
                        @endif
                        </tbody>
                    </table>
                    <div class="pagination align-left">
                        {{$operatorlist->appends([ "keyword" => $filter['keyword']])->render('frontend.common.pagination')}}
                    </div><!-- .pagination -->
                </div><!-- .member-place-wrap -->
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    <script>
        $(document).ready(function () {
            if ($(".js-switch")[0]) {
                var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                elems.forEach(function (html) {
                    var switchery = new Switchery(html, {
                        color: '#26B99A'
                    });
                });
            }
        });

        // Switchery
        $(document).on("change", ".user_status", function () {
            let user_id = $(this).attr('data-id');
            let status = $(this).is(':checked');
            let data_resp = callAPI({
                url: getUrlAPI('/users/status', 'api'),
                method: "put",
                body: {
                    "user_id": user_id,
                    "status": status ? 1 : 0
                }
            });
            data_resp.then(res => {
                if (res.code === 200) {
                    toastr.success(res.message);
                    //notify(res.message);
                } else {
                    console.log(res);
                    toastr.success(res.message);
                    //notify('Error!', 'error');
                }
            });
        });
    </script>
@endpush
