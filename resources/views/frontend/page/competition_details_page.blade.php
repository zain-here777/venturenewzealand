@extends('frontend.layouts.template')
@php
    $contact_title_bg = "style='background-image:url(images/contact-01.png)'";
@endphp
@section('main')
    <main id="main" class="site-main">
        <!-- <div class="page-title page-title--small align-left">
            <div class="container">
                <div class="page-title__content d-flex align-items-center">
                    <div>
                        <h1 class="page-title__name">Competitions</h1>
                        <p class="page-title__slogan">{{__('Participate here to win prizes!')}}</p>

                        @if(!isOperatorUser() && auth()->user())
                        @php
                            $balance = cleanDecimalZeros(App\Models\RewardPointTransaction::getBalance());
                        @endphp
                    </div>
                        <p  class="page-title__slogan ml-auto">Your Points : {{$balance}}</p>
                    @endif
                </div>
            </div>
        </div> --><!-- .page-title -->
        <div class="site-content">
                <div class="page-title page-title--small align-left mb-0 pt-0">
                        <div class="page-title__content d-flex align-items-center">
                            <img src="{{asset('assets/images/Competition.png')}}" alt="banner image" class="img-fluid comp-banner-img">
                            {{-- <div>
                                <h1 class="page-title__name">Competitions</h1>
                                <p class="page-title__slogan">{{__('Participate here to win prizes!')}}</p>

                                @if(!isOperatorUser() && auth()->user())
                                @php
                                    $balance = cleanDecimalZeros(App\Models\RewardPointTransaction::getBalance());
                                @endphp
                            </div>
                                <p  class="page-title__slogan ml-auto">Your Points : {{$balance}}</p> --}}
                            {{-- @endif --}}
                        </div>
                </div>
                <div class="container">
                    <div class="competition_detail_banner pt-0">
                        <div class="zoom-in-zoom-out text-center"><h3>Thank you for the participation..!</h3></div>
                        @if($alreadyParticipated)
                        <p style="font-size: 20px;color: orange;border: 1px solid;padding: 10px;margin-bottom: 15px;">You have already participated in this competition!</p>
                        @endif
                        <div class="row mt-3">
                            <div class="col-lg-6">
                                <div class="competition_details_inside">
                                    <div class="flex-div-li">
                                        <div class="competition_banner">
                                            <h2 class="mb-2">{{$competition->title}}</h2>
                                        </div>
                                        <p>{{$competition->description}}</p>
                                    </div>
                                    <div class="flex-div-li d-flex">
                                        <div class="comp_rules mb-3">
                                            <h2 class="mb-3" style="font-size: 16px;">Terms and Conditions:</h2>
                                                <div>{!!$competition->terms_and_conditions!!}</div>
                                        </div>
                                        <div class="comp_rules">
                                            <div class="box-div">
                                                <div class="title_inside">
                                                    <p class="small_title"><b>Entry Fee Points:</b> {{cleanDecimalZeros($competition->entry_fee_points)}}</p>
                                                </div>
                                                @if(!$alreadyParticipated)
                                            <a href="javascript:void(0);" class="btn d-block mt-4 @guest open-login @endguest"
                                            @guest @else data-toggle="modal" data-target="#participate_now_modal"  @endguest
                                            >Participate Now</a>
                                            @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="right-image">
                                    @if($competition->image)
                                        <img src="{{getImageUrl($competition->image)}}" class="w-100">
                                    @else
                                        <img src="assets/images/Ranking_Isometric.svg" class="w-100">
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->


    <div class="modal fade" id="participate_now_modal" tabindex="-1" role="dialog" aria-labelledby="participate_now_modal" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="modal-title" id="myModalLabel">Are you sure?</h2>
            <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body member-wrap mb-0">
          Are you sure want to participate in this competition? Your {{cleanDecimalZeros($competition->entry_fee_points)}} points will be deducted.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">Close</button>
            <button type="button" class="btn" id="participate_btn" onclick="participateNow()" data-dismiss="modal">Participate</button>
            <button type="button" class="btn js-confetti" id="js-confetti" hidden>Placeholder dummy btn</button>
          </div>
        </div>
      </div>
    </div>

@stop

@push('scripts')
    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

            function participateNow(){
                // $('#participate_btn').attr('disabled',true);
                $(".zoom-in-zoom-out h3").css("display","none");

                $.ajax({
                    url: getUrlAPI('competition_participate/{{$competition->id}}', ''),
                    data: {},
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        if (res.status) {
                            Tost('Participation success!','success');
                            $('#js-confetti').trigger('click');
                        } else {
                            Tost(res.message,'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        Tost('An error occurred!','error');
                        console.log(xhr.responseText);
                    }
                });//ajax

            }
    </script>
@endpush
