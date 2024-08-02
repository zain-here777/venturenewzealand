$('#plan_feature .modal-body').html($('#plan_modal_body_user').html());
$('#price_on_stripe_modal').html($('#user_price').html());
$('#payment-form').attr('action', "{{ route('stripe_charge') }}");
$('#email-stripe').val('{{ auth()->user()->email }}');
$('#plan_feature').modal('toggle');
