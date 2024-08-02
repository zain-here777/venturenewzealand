@extends('frontend.layouts.template')
@php
    $contact_title_bg = "style='background-image:url(images/contact-01.png)'";
@endphp
@section('main')
    <main id="main" class="site-main contact-main reward_main">
        <div class="site-content pb-4">
        <div class="page-title page-title--small align-left" {!! $contact_title_bg !!}>
            <div class="container">
                <div class="page-title__content">
                    <h1 class="page-title__name">{{__('Reward History')}}</h1>
                    <p class="page-title__slogan">{{__('')}}</p>
                </div>
            </div>
        </div><!-- .page-title -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">      
                        
                        <div class="reward_history">
                            @if(count($reward_point_transactions)!=0)
                                <input type="hidden" id="page_num" value="1" />
                                <input type="hidden" id="total" value="2" />
                            @else
                                <input type="hidden" id="page_num" value="1" />
                                <input type="hidden" id="total" value="0" />
                            @endif
                            
                            <ul id="transaction_ul">
                                @forelse($reward_point_transactions as $transaction)
                                    @include('frontend.common.reward_transaction_item')
                                @empty
                                <li>No Reward Transactions</li>
                                @endforelse
                            </ul>
                            <div class="data-loader text-center d-none">
                                <i class="la la-spinner la-3x la-spin"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        @if(!isOperatorUser())
                            @php
                                $balance = cleanDecimalZeros(App\Models\RewardPointTransaction::getBalance());
                            @endphp
                                <div class="rewards_section member-wrap" style="margin-top: 10px;">
                                    <h1>Reward Points</h1>
                                    <div class="reward_points_sections">
                                        <p>Point balance</p>
                                        <h2>{{$balance}}</h2>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')

    <script>
        $(document).ready(function() {
            $(window).scroll(function() {
                if($(window).scrollTop() == ($(document).height() - $(window).height()) ) {
                    // ajax call get data from server and append to the div
                    let page_num=$('#page_num').val();
                    page_num++;

                    let total = $('#total').val();
                    if(page_num <= total){
                        $('#page_num').val(page_num);
                        paginateFunction($('#page_num').val());
                    }
                }
            });
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    function paginateFunction(page_num){

        $('#transaction_ul').toggleClass('div_loader');
        $('.data-loader').toggleClass('d-none');

        $.ajax({
            url: "{{ route('reward_history') }}",
            type: "POST",
            data: {page:page_num},
            dataType: 'json',
            success: function(result)
            {
                $('#transaction_ul').toggleClass('div_loader');
                $('.data-loader').toggleClass('d-none');

                if (result.status == true) {

                    $('#page_num').val(result.data.current_page);
                    $('#total').val(result.data.total/result.data.per_page);

                    if(result.html){
                        result.html.forEach(element => {
                            $('#transaction_ul').append(element).show('slow');
                        });
                    }

                }
            },
            error: function () {
                $('#transaction_ul').toggleClass('div_loader');
                $('.data-loader').toggleClass('d-none');
            }
        });
    }
    </script>
    

@endpush
