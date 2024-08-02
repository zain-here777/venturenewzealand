@extends('frontend.layouts.template')
@section('main')

<main id="main" class="site-main">
    <div class="site-content">
        <div class="banner-bg"  style="background-image:url(/assets/images/banner-image.png);">
            <h2>How It Works</h2>
        </div>
        <div class="how-it-content">
            <div class="container">
            <div class="row how-it-content-ul">
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/customization.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Customisation</h3>
                            <p>Login to your profile to add up to 3 products, change your deals and customise your profile.
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/payicon.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Instant Payments</h3>
                            <p>Get paid instantly by setting up your own stripe connect account.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/great-pricing.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Great Pricing</h3>
                            <p>Only $99 a month and pay no commission fee on your listed products.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/noun-star.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Product Features</h3>
                            <p>Features any one of your deals so users can easily snap up a fantastic deal.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/notification.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Notifications</h3>
                            <p>Notify all company followers when you add or update existing products.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>
@stop

