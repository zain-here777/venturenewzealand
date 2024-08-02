$('#plan_feature .modal-body').html($('#plan_modal_body_operator').html());
$('#price_on_stripe_modal').html($('#operator_price').html());
$('#payment-form').attr('action', "{{ route('stripe_subscription') }}");
$('#email-stripe').val('{{ auth()->user()->email }}');
$('#plan_feature').modal('toggle');
