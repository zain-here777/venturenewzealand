@extends('frontend.layouts.template')
@section('main')

<main id="main" class="site-main">
    <div class="site-content">
        <div class="banner-bg"  style="background-image:url(/assets/images/banner-image.png);">
            <h2>How It Works</h2>
        </div>
        <div class="how-it-content user">
            <div class="container">
            <div class="row how-it-content-ul">
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/attractions.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Endless Attractions</h3>
                            <p>Take in all of New Zealand has to offer with our large list of free walks, sight-seeing attractions and adventure activites</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/planing.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Easy Planning</h3>
                            <p>Plan a weekend getaway by checking out all the attractions in your area, all in one place.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/great-pricing.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Best Pricing</h3>
                            <p>Venture New Zealand combines all your travel expenses into a single
                                purchase at the best price possible, allowing you to book everything from
                                 food to fun with a single click.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/qr-code.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Monthly Competitions and incentives</h3>
                            <p>Scan the Venture QR codes when you visit Tourism operators and hospitality providers to earn reward points, enter competitions and win cool giveaways. Its all part of the Venture New Zealand reward program.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/wishlist.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Create a Wishlist</h3>
                            <p>Add items and businesses to your wish list to easily keep track of pricing options and bookings.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 how-it-content-li">
                    <div class="content-card">
                        <img src="{{asset('assets/images/keep-in -touch.png')}}" alt="App Store">
                        <div class="card-ul text-center">
                            <h3>Keep In Touch</h3>
                            <p>Follow your favourite businesses and places to stay up to date on daily deals and new attractions.</p>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</main>

@stop
