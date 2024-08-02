@extends('frontend.layouts.template')
@section('main')
@include('frontend.common.box-alert')
<style type="text/css">
    .loader {
        width: 100%;
        height: 100%;
        top: 0%;
        left: 0%;
        position: absolute;
        display: none;
        opacity: 0.7;
        z-index: 99;
        text-align: center;
    }
</style>
<script src="https://js.stripe.com/v3/"></script>
<main id="main" class="site-main">
    <div class="site-content">
        <div class="container">
            <!--payment details-->
            <div class="payment-details">
                <h1 class="h1-headings">{{__('Booking Info')}}</h1>
                <form id="booking_summary_from">
                    <div class="row payment-content-grid">
                        <div class="col-lg-7">
                            <div class="row payment-form">
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('Name') }}</label>
                                        <input type="text" id="booking_name" name="booking_name" class="form-control"
                                            placeholder="Enter Name" data-rule-required="true" autocomplete="off" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('Email') }}</label>
                                        <input type="text" id="booking_email" name="booking_email" class="form-control"
                                            placeholder="Enter Email" data-rule-required="true" autocomplete="off"  data-rule-email="true"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ __('Phone number') }}</label>
                                        <input type="text" id="booking_phone_number" name="booking_phone_number" class="form-control"
                                            placeholder="Phone number" data-rule-required="true" autocomplete="off" data-rule-number="true"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 pr-0 payment-li-last">
                            <div class="order-summary">
                                <h2 class="small-text">{{__('Cart Summary')}}</h2>
                                <div class="summary-flex">
                                    <p>{{ __('Subtotal') }} :</p>
                                    <span>${{$total}}</span>
                                </div>
                                <div class="summary-flex">
                                    <p>{{ __('Booking Fee') }} :</p>
                                    @php
                                        $fee = $charge + $booking_fee;
                                    @endphp
                                    <span>${{number_format($fee, 2)}}</span>
                                </div>
                                <hr class="border-dashed">
                                <div class="summary-flex final-total">
                                    <p>{{ __('Total') }} :</p>
                                    <span>${{$totalwithcharges}}</span>
                                </div>
                                <div class="checkout-btn">
                                    <button class="btn booking_submit_btn" {{-- data-toggle="modal"
                                        data-target="#stripe_modal" --}}>{{ __('Book now') }}</button>
                                </div>
                            </div>
                            <div class="payment-method-new d-flex align-items-center">
                                <h2>{{ __('Payment Methods') }} :</h2>
                                <img src="{{asset('assets/images/payments.png')}}" alt="payments">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div><!-- .site-content -->
</main><!-- .site-main -->

<div class="modal fade" id="cancel_subscription_warning" tabindex="-1" role="dialog"
    aria-labelledby="cancel_subscription_warning" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel">{{ __('Are you sure?') }}</h2>
                <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body member-wrap mb-0">
                {{ __('Are you sure, you want to cancel Subscription?') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">{{ __('Close') }}</button>
                <a href="{{route('cancel_subscription')}}" class="btn">{{ __('Cancel Subscription') }}</a>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="stripe_modal" tabindex="-1" role="dialog" aria-labelledby="stripe_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="show_loader" class="loader">
                <img id="loading-image" src="{{getImageUrl('giphy.gif')}}" alt="Loading..." />
            </div>
            <form id="payment-form" action="{{route('stripe_charge_cart_booking')}}" method="post">

                <input type="hidden" name="booking_name" id="stripe_booking_name" />
                <input type="hidden" name="booking_email" id="stripe_booking_email" />
                <input type="hidden" name="booking_phone_number" id="stripe_booking_phone_number" />

                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                            alt="logo"></h2>
                    <button type="button" class="close closefirstmodal" {{-- data-dismiss="modal" aria-label="Close"
                        --}}>
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    <h3>Pay with card ${{$totalwithcharges}}</h3>
                    <div class="card_info form-underline">
                        <div class="card-row">
                            <span class="visa"></span>
                            <span class="mastercard"></span>
                            <span class="amex"></span>
                            <span class="discover"></span>
                        </div>
                        <div class="fomr_field">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="field-input">
                                        <div class="row">
                                            <div>
                                                <label for="info">Card Info</label>
                                            </div>
                                            <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-6 text-right">
                                    <label for="info">Expiry Date&nbsp;&nbsp;&nbsp;CVV&nbsp;</label>
                                </div> -->
                                        </div>
                                    </div>
                                    <div id="booking-card-element" class="booking_summary">
                                        <!--Stripe.js injects the Card Element-->
                                    </div>

                                    <div id="address-element" class="mt-4">
                                        <!--Stripe.js injects the Address Element-->
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closefirstmodal" {{-- data-dismiss="modal"
                        --}}>{{ __('Close') }}</button>
                    <button type="submit" class="btn btnpay">{{ __('Pay') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="Warning" class="modal fade" role="dialog" data-backdrop="false">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <p>{{ __('Are you sure you want to cancel buying your products?') }}</p>
                <button type="button" class="btn btn-danger confirmclosed">{{ __('Close') }}</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('Buy Now') }}</button>
            </div>
        </div>
    </div>
</div>

@push('style')
<style>
    .error {
        color: red;
    }
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/calendar.css') }}" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/additional-methods.min.js"></script>
<script src="{{ asset('assets/css/calendar.js') }}"></script>
<script>
    document.getElementById('booking_summary_from').addEventListener('submit', function(e){
        e.preventDefault();
        if($("#booking_summary_from").valid())
        {
            console.log("xzxzZxZx",$("#booking_summary_from").valid());
            $('#stripe_modal').modal('show');
        }
    });

    $(document).ready(function () { //Dom Ready
        $('.closefirstmodal').on('click',function () {
            $('#Warning').modal('show').on('show.bs.modal', function () {

            });
        });
    $(document).on('click','.confirmclosed',function () {
            //ClosWaring Modal Confirm Close Button
                    $('#Warning').modal('hide'); //Hide Warning Modal
                    $('#stripe_modal').modal('hide'); //Hide Form Modal
                });
    });

    $(document).on('click','.btnpay',function(){
        $(".loader").css("display", "block");
    });
    $(document).on('click','.booking_submit_btn',function(){
        let booking_name = $('#booking_name').val();
        let booking_email = $('#booking_email').val();
        let booking_phone_number = $('#booking_phone_number').val();
        $("#stripe_booking_name").val(booking_name);
        $("#stripe_booking_email").val(booking_email);
        $("#stripe_booking_phone_number").val(booking_phone_number);
    });
        // $("#booking_name").keyup(function(){
        //   let v = $(this).val();
        //   $("#stripe_booking_name").val(v);
        // });
        // $("#booking_email").keyup(function(){
        //   let v = $(this).val();
        //   $("#stripe_booking_email").val(v);
        // });
        // $("#booking_phone_number").keyup(function(){
        //   let v = $(this).val();
        //   $("#stripe_booking_phone_number").val(v);
        // });
</script>

<script>
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/apikeys
    const booking_appearance = {
        theme: 'stripe',
        rules: {
            '.Input': {
                // border: 'none',
                // boxShadow: 'none',
                // borderRadius: '0',
                // borderBottom: '2px solid #000000'
            },
            '.Input:focus': {
                // boxShadow: 'none'
            }
        }
    };
    var stripe = Stripe('{{config("services.stripe.key")}}');
    var booking_elements = stripe.elements({ appearance: booking_appearance });

    // Create an instance of the card Element.
    var booking_card = booking_elements.create('card');

    // Add an instance of the card Element into the `booking-card-element` <div>.
        booking_card.mount('#booking-card-element');

    const bookingAddressElement = booking_elements.create('address', { mode: 'shipping' });
    bookingAddressElement.mount('#address-element');

    var bookingBillingDetails = {};
    bookingAddressElement.on('change', function(event) {
        bookingBillingDetails = {
            name: event.value.name,
            address: {
                line1: event.value.address.line1,
                line2: event.value.address.line2,
                city: event.value.address.city,
                state: event.value.address.state,
                postal_code: event.value.address.postal_code,
                country: event.value.address.country
            }
        };
    });

    // Create a token or display an error when the form is submitted.
    var form = document.getElementById('payment-form');
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const card_name = document.getElementById('booking_name').value;
        stripe.createToken(booking_card, bookingBillingDetails).then(function(result) {
            if (result.error) {
                toastr.error(result.error.message);
            // Inform the customer that there was an error.
            // let errorElement = document.getElementById('card-errors');
            // errorElement.textContent = result.error.message;
            } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
            }
        });
    });
    function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
    }

</script>
@endpush

@stop
