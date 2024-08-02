@extends('frontend.layouts.template')
@php
    $contact_title_bg = "style='background-image:url(images/contact-01.png)'";
@endphp
@section('main')
    <main id="main" class="site-main">
        <div class="page-title page-title--small align-left">
            <div class="container">
                <div class="page-title__content">
                    <h1 class="page-title__name">{{$competition->title}}</h1>
                    <p class="page-title__slogan">{{__('Participate here to win more points.!')}}</p>
                </div>
            </div>
        </div><!-- .page-title -->
        <div class="site-content">
            <div class="container">
                <div class="competition_detail_banner pt-0">
                    <div class="zoom-in-zoom-out text-center"><h3>Good luck and Thank you for the participating!</h3></div>
                    @if($alreadyParticipated)
                    <p style="font-size: 20px;color: orange;border: 1px solid;padding: 10px;margin-bottom: 15px;">You have already participated in this competition!</p>
                    @endif
                    <img src="assets/images/Ranking_Isometric.svg">
                    <div class="competition_details_inside">
                        <p>{{$competition->description}}</p>
                        <!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p> -->
                        <div class="comp_rules mb-3">
                            <h2 class="mb-3">Competition Rules:</h2>
                                <div>{!!$competition->terms_and_conditions!!}</div>
                            <!-- <ul>                                
                                <li>Lorem Ipsum simply dummy</li>
                                <li>Lorem Ipsum</li>
                                <li>Lorem Ipsum simply dummy</li>
                                <li>Lorem Ipsum</li>
                                <li>Lorem Ipsum simply dummy</li>
                            </ul> -->
                        </div>
                        <div class="title_inside">
                            <p class="small_title"><b>Entry Fee Points:</b> {{cleanDecimalZeros($competition->entry_fee_points)}}</p>
                            <p class="small_title"><b>Prize Points:</b> {{cleanDecimalZeros($competition->prize_points)}}</p> 
                        </div>
                        @if(!$alreadyParticipated)
                        <a href="javascript:void(0);" class="btn mt-4 @guest open-login @endguest"
                        @guest @else data-toggle="modal" data-target="#participate_now_modal"  @endguest
                        >Participate Now</a>
                        @endif
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
                            Tost(res.message,'success');   
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