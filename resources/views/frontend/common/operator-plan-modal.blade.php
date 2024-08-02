<script src="https://js.stripe.com/v3/"></script>
<div class="modal fade" id="plan_feature" tabindex="-1" role="dialog" aria-labelledby="plan_feature" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="myModalLabel"><img
                        src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                        alt="logo"></h2>
                <button type="button" class="close close-btn-event-modal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body member-wrap mb-0">
                @if(isOperatorUser())
                @include('frontend.common.plan_modal_body_operator')
                @else
                @include('frontend.common.plan_modal_body_user')
                @endif
                {{-- <h3 class="text-center">Pricing Plan</h3> --}}

                {{-- <article class="card__content">
                    <div class="card__pricing">
                        <div class="card__pricing-number">
                            <span
                                class="card__pricing-symbol">$</span>{{App\Models\UserSubscription::getSubscriptionPriceForUserType(2)}}
                        </div>
                        <span class="card__pricing-month">/month</span>
                    </div>

                    <header class="card__header">
                        <div class="card__header-circle">
                            <img src="https://fadzrinmadu.github.io/hosted-assets/responsive-pricing-card-using-html-and-css/free-coin.png"
                                alt="" class="card__header-img">
                        </div>

                        <span
                            class="card__header-subtitle">{{App\Models\UserSubscription::getSubscriptionDaysForUserType(2)}}
                            Days</span>
                        <h1 class="card__header-title">{{getUserTypePhrase(2)}}</h1>
                    </header>

                    <ul class="card__list">
                        <li class="card__list-item">
                            <i class="fal fa-check"></i>
                            <p class="card__list-description"><span>➤</span> 3 user request</p>
                        </li>
                        <li class="card__list-item">
                            <i class="fal fa-check"></i>
                            <p class="card__list-description"><span>➤</span> 10 downloads por day</p>
                        </li>
                        <li class="card__list-item">
                            <i class="fal fa-check"></i>
                            <p class="card__list-description"><span>➤</span> Daily content updates</p>
                        </li>
                        <li class="card__list-item">
                            <i class="fal fa-check"></i>
                            <p class="card__list-description"><span>➤</span> Fully editable files</p>
                        </li>
                    </ul>

                </article> --}}
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-default close-btn-event-modal" data-dismiss="modal">Close</button>
                <button type="button" class="btn" data-dismiss="modal" data-toggle="modal"
                    data-target="#stripe_modal">Purchase Plan</button> --}}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="stripe_modal" tabindex="-1" role="dialog" aria-labelledby="stripe_modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="payment-form" action="{{route('stripe_charge')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title" id="myModalLabel"><img
                            src="{{asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png')}}"
                            alt="logo"></h2>
                    <button type="button" class="close closefirstmodal"
                    {{-- data-dismiss="modal" aria-label="Close" --}}
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body member-wrap mb-0">
                    <h3>Pay with card ${{App\Models\UserSubscription::getSubscriptionPriceForUserType(2)}}</h3>
                    <div class="card_info form-underline">
                        <div class="card-row">
                            <span class="visa"></span>
                            <span class="mastercard"></span>
                            <span class="amex"></span>
                            <span class="discover"></span>
                        </div>
                        <div class="fomr_field">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input p-0">
                                        <label for="email">Name on Card</label>
                                        <input type="text" id="card_name-stripe" value="" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="field-input p-0">
                                        <label for="email">Email</label>
                                        <input type="email" id="email-stripe" value="@auth{{auth()->user()->email}}@endauth" class="form-control" disabled>
                                    </div>
                                </div>
                                <!-- <div class="col-lg-6 col-md-6">
                        <div class="field-input">
                            <label for="cardname">Name on card</label>
                            <input type="text" id="cardname" name="name_on_card" value="">
                        </div>
                     </div> -->
                                <div class="col-lg-12 col-md-12">
                                    <!-- <div class="field-input">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="info">Card information</label>
                                    <input type="text" id="text" value="" placeholder="1234 1234 1234 1234">
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <label for="info">Expiry Date</label>
                                    <input type="text" id="text" value="" placeholder="MM/YY">
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <label for="info">CVV</label>
                                    <input type="text" id="text" value="" placeholder="123">
                                </div>
                            </div>
                        </div> -->
                                    <div class="field-input">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <label for="info">Card Info</label>
                                            </div>
                                            <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-6 text-right">
                                    <label for="info">Expiry Date&nbsp;&nbsp;&nbsp;CVV&nbsp;</label>
                                </div> -->
                                        </div>
                                    </div>
                                    <div id="card-element">
                                        <!--Stripe.js injects the Card Element-->
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closefirstmodal"
                    {{-- data-dismiss="modal" --}}
                    >Close</button>
                    <button type="submit" class="btn">Pay</button>
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
    // Set your publishable key: remember to change this to your live publishable key in production
    // See your keys here: https://dashboard.stripe.com/apikeys
    var stripe = Stripe('{{config("services.stripe.key")}}');
    var elements = stripe.elements();

    // Custom styling can be passed to options when creating an Element.
    var style = {
    base: {
        // Add your base input styles here. For example:
        fontSize: '14px',
        color: '#32325d',
    },
    };

    // Create an instance of the card Element.
    var card = elements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>.
    card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
            event.preventDefault();
            const card_name = document.getElementById('card_name-stripe').value;
            stripe.createToken(card,{name: card_name}).then(function(result) {
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

function closeModalEvent(){
    setTimeout(() => {
        location.reload();
    }, 1400);
}

$( ".close-btn-event-modal" ).click(function() {
    closeModalEvent();
});

$(document).keyup(function (e) {
    if (e.which == 27 && (e.target.id === "stripe_modal" || e.target.id === "plan_feature")) {
        closeModalEvent();
    }
})

$(document).click(function (e) {
    if (e.target.id === "stripe_modal" || e.target.id === "plan_feature") {
        closeModalEvent();
    }
})
</script>
