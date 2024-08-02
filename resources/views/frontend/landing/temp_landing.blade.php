<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Venture New Zealand</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/libs/bootstrap/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/temp_landing.css?') . time() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/temp_landing_modal.css?') . time() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/toastr.css') }}" />
    <link rel="icon" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">
</head>

<body>
    <div class="right_header">
        <a id="btnSignIn" class="sign_in" href="#">Sign In</a>
    </div>

    <div class="menu">
        <div class="play menu_item">
            <div class="play_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'play',
                    ])</span>
                    <h3>Play</h3>
                </div>
                <p>List your activity on Venture New Zealand, accept bookings and create availability.</p>
            </div>
            <div class="play_img menu_img">
                <img src="./uploads/63e9bf42e5eb2_1676263234.jpg" alt="">
            </div>
        </div>
        <div class="see menu_item">
            <div class="see_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'see',
                    ])</span>
                    <h3>See</h3>
                </div>
                <p>Our listings encompass cost-free experiences aswell, making trip planning to any destination a
                    breeze!</p>
            </div>
            <div class="see_img menu_img">
                <img src="./uploads/61c7b7ba2f709_1640478650.jpg" alt="">
            </div>
        </div>
        <div class="stay menu_item">
            <div class="stay_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'stay',
                    ])</span>
                    <h3>Stay</h3>
                </div>
                <p>Promote your lodging establishment now and experience the benefits of direct bookings, minus the
                    burden of commissions.</p>
            </div>
            <div class="stay_img menu_img">
                <img src="./uploads/stay.jpg" alt="">
            </div>
        </div>
        <div class="eat menu_item">
            <div class="eat_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'eat',
                    ])</span>
                    <h3>Eat</h3>
                </div>
                <p> Secure direct reservations, incorporate discounts, feature delectable meal specials, and update your
                    availability with ease.</p>
            </div>
            <div class="eat_img menu_img">
                <img src="./uploads/eat.jpg" alt="">
            </div>
        </div>
        <div class="rent menu_item">
            <div class="rent_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'rent',
                    ])</span>
                    <h3>Rent</h3>
                </div>
                <p>whether you're offering vans, campers, or cars. Say goodbye to commissions and welcome direct
                    customers through Venture New Zealand</p>
            </div>
            <div class="rent_img menu_img">
                <img src="./uploads/61a748cbc9363_1638353099.jpg" alt="">
            </div>
        </div>
        <div class="travel menu_item">
            <div class="travel_description menu_content">
                <div class="d-flex menu_item_title align-items-center">
                    <span class="mr-2">@include('frontend.landing.svgImage', [
                        'cat' => 'travel',
                    ])</span>
                    <h3>Travel</h3>
                </div>
                <p>Whether you specialize in airport transfers, bus services, or operate a small airline, start
                    accepting bookings from your clientele today</p>
            </div>
            <div class="travel_img menu_img">
                <img src="./uploads/62eb9f2ba2559_1659608875.jpg" alt="">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="{{ asset(setting('logo_white') ? 'uploads/' . setting('logo_white') : 'assets/images/assets/logo.png') }}"
                    alt="logo">
            </div>
        </div>

        <div class="content">
            <div class="description">
                <div class="coming">
                    Coming Soon
                </div>

                <div class="ready">
                    Venture New Zealand is almost ready. Be one of the first to experience it
                    <br />
                    by entering your email below. You will be notified as soon as it's live. Let's do this!
                </div>
            </div>

            <div class="singup-form">
                <form id="frmAddSubscription" action="#" method="POST">
                    @csrf
                    <div class="user_name">
                        <input type="text" name="fullname" class="input_user_name" placeholder="Enter Your First and Last Name"
                            required />
                    </div>

                    <div class="email_address">
                        <input type="text" name="email" class="input_email_address" placeholder="Enter Your Email Address"
                            required />
                        <input type="submit" id="btnAddSubscription" class="btn user-signup" value="SIGN ME UP!" />
                    </div>
                </form>
            </div>

            <div class="operator_desc">
                <div class="question">
                    Are you an Operator?
                </div>
                <div class="answer">
                    Get your Business out there and engage directly with Venture NZ visitors.
                </div>

                <div class="operator-button">
                    <button class="btn operator-signup" id="btnOperatorSignup">OPERATOR SIGNUP</button>
                    <a target="_blank" href={{ url('/operator-presentation') }} class="btn find-out-more">Find Out
                        More</a>
                </div>
            </div>

            <div class="copyright">
                &copy; 2023 Venture New Zealand. All Rights Reserved.
            </div>
        </div>

        @include('frontend.landing.signup')

        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    </div>
</body>

</html>
