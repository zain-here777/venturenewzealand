@extends('frontend.layouts.template')
@php
    $contact_title_bg = "style='background-image:url(images/contact-01.png)'";
@endphp
@section('main')
    <main id="main" class="site-main contact-main reward_main">
        <div class="page-title page-title--small align-left" {!! $contact_title_bg !!}>
            <div class="container">
                <div class="page-title__content">
                    <h1 class="page-title__name">{{__('Reward')}}</h1>
                    <p class="page-title__slogan">{{__('')}}</p>
                </div>
            </div>
        </div><!-- .page-title -->
        <div class="site-content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">

                        @guest
                            <div class="contact-text">
                                <div class="login_reward">
                                    <h2>Please login to get reward points.</h2>
                                    <img src="../assets/images/img_svg2.svg">
                                    <a href="javascript:void(0);" class="btn open-login">Login</a>
                                </div>
                            </div>
                        @else

                            @if($response_code==2)
                                <div class="contact-text">
                                    <div class="login_reward">
                                        <h2>Congrats! You have earned {{$points}} points.</h2>
                                        <img src="../assets/images/img_svg3.svg">
                                        <img src="../assets/images/spark.png" class="spark1">
                                        <img src="../assets/images/spark.png" class="spark2">
                                        <a href="{{route('reward_history')}}" class="link">View all rewards</a>
                                    </div>
                                </div>
                            @endif

                            @if($response_code==3)
                                <div class="contact-text">
                                    <div class="login_reward">
                                        <h2>Opps! You have already earned this reward.</h2>
                                        <img src="../assets/images/img_svg1.svg">
                                        <a href="{{url('/')}}" class="link">Back to Home</a>
                                    </div>
                                </div>
                            @endif

                            @if($response_code==4)
                                <div class="contact-text">
                                    <div class="login_reward">
                                        <h2>Opps..! Place not found.</h2>
                                        <img src="../assets/images/img_svg1.svg">
                                        <a href="{{url('/')}}" class="link">Back to Home</a>
                                    </div>
                                </div>
                            @endif

                            @if($response_code==5)
                                <div class="contact-text">
                                    <div class="login_reward">
                                        <h2>Please login with user account to get reward points.</h2>
                                        <img src="../assets/images/img_svg2.svg">
                                        <!-- <a href="javascript:void(0);" class="btn open-login">Login</a> -->
                                    </div>
                                </div>
                            @endif

                            @if($response_code==6)
                                <div class="contact-text">
                                    <div class="login_reward">
                                        <h2>You dont have active membership plan.</h2>
                                        <img src="../assets/images/img_svg2.svg">
                                        <a href="javascript:void(0);" class="btn" >Login</a>
                                    </div>
                                </div>
                            @endif

                        @endguest



                    </div>

                </div>
            </div>
        </div><!-- .site-content -->
    </main><!-- .site-main -->
@stop

@push('scripts')
    @guest
        <script>
            $(document).ready(function() {
                // $('.popup--left').removeClass('open');
                // $('.nav-login').addClass('active');
                // $('.form-log').fadeIn(0);
                // $('.nav-signup').removeClass('active');
                // $('.form-sign').fadeOut(0);
                // $('.form-forgotpass').fadeOut(0);
                // $('.popup-background').fadeIn(0);
                // $('.popup-form').toggleClass('open');
            });

        </script>
    @endguest
@endpush
