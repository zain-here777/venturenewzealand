$(document).ready(function () { //Dom Ready
    $('.closefirstmodal').on('click',function () {
        $('#Warning').modal('show').on('show.bs.modal', function () {

        });
    });
$(document).on('click','.confirmclosed',function () {
        //ClosWaring Modal Confirm Close Button
                $('#Warning').modal('hide'); //Hide Warning Modal
                $('#stripe_modal').modal('hide'); //Hide Form Modal
                window.location.href = "/";
            });
});
// Set your publishable key: remember to change this to your live publishable key in production
// See your keys here: https://dashboard.stripe.com/apikeys

const appearance = {
    theme: 'stripe',
    rules: {
        // '.Input': {

        //     backgroundColor: '#DFEEE2',
        //     border: '2px solid #C9F0C8',
        //     borderRadius: '5px',

        //     // border: 'none',
        //     // boxShadow: 'none',
        //     // borderRadius: '0',
        //     // borderBottom: '2px solid #000000'
        // },
        // '.Input:focus': {
        //     boxShadow: 'none'
        // }
    }
};

var stripe = Stripe(stripe_key);
var elements = stripe.elements({ appearance });

// Custom styling can be passed to options when creating an Element.
var style = {
base: {
    // Add your base input styles here. For example:
    fontSize: '17px',
    color: '#32325d',
},
};

// Create an instance of the card Element.
// var cardNumber = elements.create('cardNumber', {style: style});
// var cardExpiry = elements.create('cardExpiry', {style: style});
// var cardCvc = elements.create('cardCvc', {style: style});

const options = { mode: 'shipping' }

// Create an instance of the card Element.
var card = elements.create('card');

// Add an instance of the card Element into the `booking-card-element` <div>.
card.mount('#card-element');

const addressElement = elements.create('address', options);
addressElement.mount('#plan-address-element');

// Add an instance of the card Element into the `card-element` <div>.
// cardNumber.mount('#card-number-element');
// cardExpiry.mount('#card-expiry-element');
// cardCvc.mount('#card-cvc-element');

// cardNumber.on('focus', function () {
//     $("#card-number-element").css("border-color", "#70AFE2");
//   });
// cardNumber.on('blur', function () {
//     $("#card-number-element").css("border-color", "#C9F0C8");
// });

// cardExpiry.on('focus', function () {
//     $("#card-expiry-element").css("border-color", "#70AFE2");
//   });
// cardExpiry.on('blur', function () {
//     $("#card-expiry-element").css("border-color", "#C9F0C8");
// });

// cardExpiry.on('change', function (event) {
//     // debugger;
//     console.log(event.value);
// });

var billingDetails = {};
addressElement.on('change', function(event) {
    billingDetails = {
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

// $('#stripe_modal').modal('show');

// cardExpiry.on('keydown', function(event) {
//     var keyPressed = event.key;
//     console.log('Key pressed:', keyPressed);
//   });
// cardCvc.on('focus', function () {
//     $("#card-cvc-element").css("border-color", "#70AFE2");
//   });
//   cardCvc.on('blur', function () {
//     $("#card-cvc-element").css("border-color", "#C9F0C8");
// });

        // Create a token or display an error when the form is submitted.
        var sub_form = document.getElementById('subscription-payment-form');
        sub_form.addEventListener('submit', function(event) {
            event.preventDefault();
            // const card_name = document.getElementById('card_name-stripe').value;
            var promo_code = document.getElementById('promocode-stripe');
            var promoCode = promo_code ? promo_code.value : "";
            stripe.createToken(card,
                billingDetails
                // {
                //     name: card_name,
                //     // cvc: cardCvc,
                //     // exp: cardExpiry
                //     // exp_month: cardExpiry.split('/')[0].trim(),
                //     // exp_year: cardExpiry.split('/')[1].trim()
                // }
                ).then(function(result) {
                if (result.error) {
                    toastr.error(result.error.message);
                // Inform the customer that there was an error.
                // let errorElement = document.getElementById('card-errors');
                // errorElement.textContent = result.error.message;
                } else {
                    if(promo_code && promo_code.length){
                        if(promoCode !== ""){
                            $.ajax({
                                url: 'stripe/validate-promo-code',
                                type: 'POST',
                                data: {promocode: promoCode},
                                dataType: 'json',
                                success: function(response) {
                                    if (response.valid === true) {
                                        // Promo code is valid, submit the form
                                        stripeTokenHandler(result.token);
                                    } else {
                                        // Promo code is invalid, display an error message
                                        $("#promocode_err").html(response.message);
                                    }
                                },
                                error: function(xhr) {
                                    // Something went wrong, display an error message
                                    toastr.error('An error occurred while validating the promo code');
                                }
                            });
                        } else {
                            // Send the token to your server.
                            sub_stripeTokenHandler(result.token);
                        }
                    }else{
                        // Send the token to your server.
                        sub_stripeTokenHandler(result.token);
                    }
                }
            });
        });


        function sub_stripeTokenHandler(token) {
        // Insert the token ID into the form so it gets submitted to the server
        var sub_form = document.getElementById('subscription-payment-form');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token.id);
        sub_form.appendChild(hiddenInput);

        // Submit the form
        sub_form.submit();
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
