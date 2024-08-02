<style>
    #card_name-stripe{
        background-color: #DFEEE2 !important;
        border: 2px solid #C9F0C8 !important;
        border-radius: 5px;
        padding: 0 12px;
    }
    #card_name-stripe:focus{
        border: 2px solid #70AFE2 !important;
    }
    #promocode-stripe{
        background-color: #DFEEE2 !important;
        border: 2px solid #C9F0C8 !important;
        border-radius: 5px;
    }
    #promocode-stripe:focus{
        border: 2px solid #70AFE2 !important;
    }
    #email-stripe{
        background-color: #DFEEE2 !important;
        border: 2px solid #C9F0C8 !important;
        border-radius: 5px;
        padding: 0 12px;
    }
    #card-number-element, #card-expiry-element, #card-cvc-element{
        margin-bottom: 20px;
        padding: 8px 12px;
        background-color: #DFEEE2;
        border: 2px solid #C9F0C8;
        border-radius: 5px;
    }
    #card-number-element:focus-within {
        border-color: blue;
    }
    #stripe_modal .modal-footer>div:first-of-type{
        padding-left: 0;
    }
    #stripe_modal .modal-footer>div:last-of-type{
        display: flex;
        justify-content: end;
        gap: 5px;
    }
    @media (max-width:768px) {
        .pl-0-md{
            padding-left: 0;
        }
        .pr-0-md{
            padding-right: 0;
        }
        .mt-10-md{
            padding-top: 10px;
        }
    }

</style>
<script src="https://js.stripe.com/v3/"></script>
<div class="modal fade" data-backdrop="static" id="plan_feature" tabindex="-1" role="dialog"
    aria-labelledby="plan_feature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel"><img
                        src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                        alt="logo"></h2>
                <a class="close close-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body member-wrap mb-0">
                @if(isOperatorUser())
                @include('frontend.common.plan_modal_body_operator')
                @else
                @include('frontend.common.plan_modal_body_user')
                @endif
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                    data-target="#stripe_modal">Purchase Plan</button>
            </div> --}}
        </div>
    </div>
</div>

<div class="modal fade" data-backdrop="static" id="stripe_modal" tabindex="-1" role="dialog"
    aria-labelledby="stripe_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="subscription-payment-form" action="{{route('stripe_charge')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                            alt="logo"></h2>
                    <button type="button" class="close  closefirstmodal" {{-- data-dismiss="modal" aria-label="Close"
                        --}}>
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body member-wrap mb-0">
                    <h3>Pay with card <span
                            id="price_on_stripe_modal">${{App\Models\UserSubscription::getSubscriptionPriceForUserType(2)}}</span>
                    </h3>
                    <div class="card_info form-underline">
                        <div class="card-row">
                            <span class="visa"></span>
                            <span class="mastercard"></span>
                            <span class="amex"></span>
                            <span class="discover"></span>
                        </div>
                        <div class="fomr_field">
                            {{-- <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input p-0">
                                        <input type="text" id="card_name-stripe" value="" class="form-control" placeholder="Name on Card">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input p-0">
                                        <input type="email" id="email-stripe" value="@auth{{auth()->user()->email}}@endauth" 
                                            placeholder="E-Mail"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 row m-0">
                                    <div class="col-lg-8 col-md-8 pl-0 pr-0-md" >
                                        <div id="card-number-element"></div>
                                        <!--Stripe.js injects the Card Element-->
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 pl-0-md" >
                                        <div id="card-expiry-element"></div>
                                        <!--Stripe.js injects the Card Element-->
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 pr-0" >
                                        <div id="card-cvc-element"></div>
                                        <!--Stripe.js injects the Card Element-->
                                    </div>
                                </div>
                            </div> --}}

                            <div id="card-element" class="booking_summary">
                                <!--Stripe.js injects the Card Element-->
                            </div>

                            <div class="row">
                                <div id="plan-address-element" class="mt-4 mb-4 col-lg-12">
                                    <!--Stripe.js injects the Address Element-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                    <div class="col-lg-6 col-md-6 col-sm-12" style="margin-right:0; padding:0;">
                        @if(isOperatorUser())
                        <div class="field-input p-0">
                            <p id="promocode_err" style="color:red; font-size:15px; padding-bottom:7px;"></p>
                            <input type="text" id="promocode-stripe" name="promocode" value="" class="form-control" placeholder="Promo Code">
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 mt-10-md" style="margin-left:0;">
                        <button type="button" class="btn btn-default closefirstmodal" {{-- data-dismiss="modal"
                        --}}>Close</button>
                        <button type="submit" class="btn">Pay</button>
                    </div>

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
                <p>Are you sure you want to cancel buying your subscription?</p>
                <button type="button" class="btn btn-danger confirmclosed">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Buy Now</button>
            </div>
        </div>
    </div>
</div>

<script>
// var stripe_key = '{{config("services.stripe.key")}}';
var stripe_key = '{{config("services.stripe.key")}}';
</script>

<script src="{{ asset('assets/js/plan_modal.js') }}">
</script>

<!--  -->

<div style="display: none;">

    <div id="operator_price">${{App\Models\UserSubscription::getSubscriptionPriceForUserType(2)}}</div>
    <div id="user_price">${{App\Models\UserSubscription::getSubscriptionPriceForUserType(1)}}</div>

    @include('frontend.common.plan_modal_body_operator')
    @include('frontend.common.plan_modal_body_user')

</div>

@push('scripts')
@auth
    @if (auth()->user()->subscription_valid_till == null &&
    auth()->user()->isOperator())
        @if (App\Models\User::isFreeSubscriptionAllow())
            <script>
                $('#plan_feature .modal-body').html($('#plan_modal_body_operator').html());
                $('#price_on_stripe_modal').html($('#operator_price').html());
                $('#payment-form').attr('action', "{{ route('stripe_subscription') }}");
                $('#email-stripe').val('{{ auth()->user()->email }}');
                // $('#stripe_modal').modal('toggle');
                $('#plan_feature').modal('toggle');
            </script>
        @else
        <script>
            $('#plan_feature .modal-body').html($('#plan_modal_body_operator').html());
            $('#price_on_stripe_modal').html($('#operator_price').html());
            $('#payment-form').attr('action', "{{ route('stripe_subscription') }}");
            $('#email-stripe').val('{{ auth()->user()->email }}');
            $('#plan_feature').modal('toggle');
        </script>
        @endif
    @endif
    @if (Session::get('paid'))
        @if (auth()->user()->subscription_valid_till == null &&
            auth()->user()->isUser() &&
            Session::get('alreadyUser'))
            <script>
                $('#plan_feature .modal-body').html($('#plan_modal_body_user').html());
                $('#price_on_stripe_modal').html($('#user_price').html());
                $('#payment-form').attr('action', "{{ route('stripe_charge') }}");
                $('#email-stripe').val('{{ auth()->user()->email }}');
                $('#plan_feature').modal('toggle');
            </script>
        @endif
    @endif
@endauth
@endpush
