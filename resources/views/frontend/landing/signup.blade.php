<div class="popup popup-form custom-dialog modal" id="LoginSingUpModel" tabindex="-1" aria-labelledby="faceBookLabel"
    aria-hidden="true">
    <div class="d-flex align-items-center h-100">
        <div class="dialog-wrapper">
            <img src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}"
                alt="logo" class="modal-logo">
            <a title="Close" href="#" class="popup__close" data-dismiss="modal" aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
                    <path fill="#5D5D5D" fill-rule="nonzero"
                        d="M9.3 8.302l6.157-6.156a.706.706 0 1 0-.999-.999L8.302 7.304 2.146 1.148a.706.706 0 1 0-.999.999l6.157 6.156-6.156 6.155a.706.706 0 0 0 .998.999L8.302 9.3l6.156 6.156a.706.706 0 1 0 .998-.999L9.301 8.302z" />
                </svg>
            </a><!-- .popup__close -->
            <ul class="choose-form">
                <li id="tabLogin" class="tab-item nav-login active">
                    <a title="Log In" class="font-weight-bold" href="#">{{ __('Login') }}</a>
                </li>
                <li id="tabRegister" class="tab-item nav-signup">
                    <a title="Sign Up" class="font-weight-bold" href="#">{{ __('Sign Up') }}</a>
                </li>
            </ul>
            <div class="popup-content">
                <form class="form-log form-content" id="frmLogin" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form_field">
                        <div class="field-input">
                            <input type="text" id="email" name="email" placeholder="{{ __('Email Address') }}"
                                required>
                        </div>
                        <div class="field-input">
                            <input type="password" id="password" name="password" placeholder="{{ __('Password') }}"
                                required>
                        </div>
                    </div>

                    <div class="choose-form mb-0">
                        <a title="{{ __('Forgot password') }}" class="forgot_pass" id="btnForgotPassword"
                            href="#forgot_password">{{ __('Forgot password') }}</a>
                    </div>
                    <button type="submit" class="gl-button btn button w-100"
                        id="submit_login">{{ __('Login') }}</button>
                </form>

                <form class="form-sign form-content hidden" id="frmRegister" action="{{ route('register') }}"
                    method="post">
                    @csrf
                    <div class="form_field">
                        <div class="field-input">
                            <input type="text" id="register_name" name="name" placeholder="{{ __('Full Name') }}"
                                required>
                        </div>
                        <div class="field-input">
                            <input type="email" id="register_email" name="email"
                                placeholder="{{ __('Email Address') }}" required>
                        </div>
                        <div class="field-input">
                            <input type="password" id="register_password" name="password"
                                placeholder="{{ __('Password') }}" required>
                        </div>
                        <div class="field-input">
                            <input type="password" id="register_password_confirmation" name="password_confirmation"
                                placeholder="{{ __('Confirm Password') }}" required>
                        </div>
                        <input type="hidden" id="user_type" name="user_type" value="2">
                    </div>

                    <div class="form-group mb-2" style="margin-left: 0px;">
                        <div class="form-group" style="margin-left: 0px;">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    </div>

                    <div class="field-check">
                        <label for="accept_all">
                            <input type="checkbox" id="accept_all" name="All_user_accept">
                            {{ __('Accept the') }} <a title="Terms"
                                href="{{ route('page_terms_and_conditions') }}">{{ __('Terms and Conditions & Privacy Policy') }}</a>
                            <span class="checkmark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                    viewBox="0 0 8 6">
                                    <path fill="#FFF" fill-rule="nonzero"
                                        d="M2.166 4.444L.768 3.047 0 3.815 1.844 5.66l.002-.002.337.337L7.389.788 6.605.005z" />
                                </svg>
                            </span>
                        </label>
                        <label for="accept_operator" class="operator_check">
                            <input type="checkbox" id="accept_operator" name="Operator_user_accept">
                            {{ __(' I confirm that my business is part of tourism and hospitality.') }}
                            <span class="checkmark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6"
                                    viewBox="0 0 8 6">
                                    <path fill="#FFF" fill-rule="nonzero"
                                        d="M2.166 4.444L.768 3.047 0 3.815 1.844 5.66l.002-.002.337.337L7.389.788 6.605.005z" />
                                </svg>
                            </span>
                        </label>
                    </div>
                    <button type="submit" class="gl-button btn button w-100"
                        id="submit_register">{{ __('Sign Up') }}</button>
                </form>

                <form class="form-forgotpass form-content hidden" id="frmForgotPassword"
                    action="{{ route('api_user_forgot_password') }}" method="POST">
                    @csrf
                    <p class="choose-or">
                        <span>{{ __('Lost your password? Please enter your email address. You will receive a link to create a new password via email.') }}</span>
                    </p>

                    <small class="form-text text-danger hidden" id="fp_error">error!</small>
                    <small class="form-text text-success hidden" id="fp_success">error!</small>
                    <div class="field-input">
                        <input type="text" id="txtEmail" name="email" placeholder="Email Address" required>
                    </div>
                    <button type="submit" class="gl-button btn button w-100"
                        id="submit_forgot_password">{{ __('Forgot password') }}</button>
                </form>
                <div class="social_signin">
                    <div style="text-align: center;">Or continue with</div>
                    <div class="col-md-12 row-block">
                        <a class="google_signin" href="{{ url('auth/google') }}">
                            <span> <img style="width:25px; height:25px;"
                                    src="{{ asset('assets/images/google-logo.svg') }}"></span>
                            <strong style="line-height: 25px;">Google</strong>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div><!-- .popup-form -->

<script src="{{ asset('assets/libs/jquery-1.12.4.js') }}"></script>
<script>
/**
 * @param $form
 * return object
 */
function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};
    $.map(unindexed_array, function(n, i) {
        indexed_array[n['name']] = n['value'];
    });
    return indexed_array;
}

function getUrlAPI(slug, type = "api") {
    const base_url = window.location.origin;
    if (type === "full")
        return slug;
    else
        return base_url + "/" + type + slug;
}

$(document).ready(function() {
    $('body').on('click', '#btnSignIn', function() {
        $('#LoginSingUpModel').modal('show');
        $('#tabLogin').trigger('click');
    });

    $('body').on('click', '#btnForgotPassword', function() {
        $('.form-content').addClass('hidden');
        $('#frmForgotPassword').removeClass('hidden');
        $('.tab-item').removeClass('active');
    });

    $('body').on('click', '#tabLogin', function() {
        $('.form-content').addClass('hidden');
        $('#frmLogin').removeClass('hidden');

        $('.tab-item').removeClass('active');
        $('#tabLogin').addClass('active');
    });

    $('body').on('click', '#tabRegister', function() {
        $('.form-content').addClass('hidden');
        $('#frmRegister').removeClass('hidden');

        $('.tab-item').removeClass('active');
        $('#tabRegister').addClass('active');
    });

    $('body').on('click', '#btnOperatorSignup', function() {
        $('#LoginSingUpModel').modal('show');
        $('#tabRegister').trigger('click');
    });

    $('#frmLogin').submit(function(event) {
        event.preventDefault();
        let $form = $(this);
        let formData = getFormData($form);
        $('#submit_login').text('Loading...').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "{{ url('/login') }}",
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#submit_login').text('Login').prop('disabled', false);
                if (response.code === 200) {
                    window.location.href = "/user/profile";
                } else {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            },
            error: function(jqXHR) {
                $('#submit_login').text('Login').prop('disabled', false);
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            }
        });
    });

    $('#frmRegister').submit(function(event) {
        event.preventDefault();

        $('.form-sign .field-check label input').each(function() {
            if (!$(this).is(':checked')) {
                return false;
            }
        });

        let $form = $(this);
        let formData = getFormData($form);
        $.ajax({
            type: "POST",
            url: "{{ url('/register') }}",
            data: formData,
            dataType: 'json',
            beforeSend: function() {
                $('#submit_register').text('Loading...').prop('disabled', true);
            },
            success: function(response) {
                $('#submit_register').text('Register').prop('disabled', false);
                console.log("response", response);
                if (response.code === 201) {
                    window.location.href = "/user/profile";
                } else if (response.code === 200) {
                    window.location.href = "/user/profile";
                } else {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            },
            error: function(jqXHR) {
                $('#submit_register').text('Register').prop('disabled', false);
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            }
        });
    });

    $('#frmAddSubscription').submit(function(event) {
        event.preventDefault();
        let $form = $(this);
        let formData = getFormData($form);
        $('#btnAddSubscription').text('Loading...').prop('disabled', true);
        $.ajax({
            type: "POST",
            url: getUrlAPI('/users/add-subscription', 'api'),
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#btnAddSubscription').text('SIGN ME UP!').prop('disabled', false);
                if (response.code === 200) {
                    toastr.success('Your subscription added successfully!!');
                } else {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            },
            error: function(jqXHR) {
                $('#btnAddSubscription').text('SIGN ME UP!').prop('disabled', false);
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    toastr.error(response.message.replaceAll('\n', '<br/>'));
                }
            }
        });
    });

    $('#frmForgotPassword').submit(function(event) {
        event.preventDefault();
        let $form = $(this);
        let formData = getFormData($form);
        $('#submit_forgot_password').text(`Loading...`).prop('disabled', true);

        $.ajax({
            type: "POST",
            url: "{{ url('/api/user/reset-password') }}",
            data: formData,
            dataType: 'json',
            success: function(response) {
                $('#submit_forgot_password').text('Forgot password').prop('disabled',
                    false);
                if (response.code === 200) {
                    $('#fp_success').show().text(response.message);
                } else {
                    $('#fp_error').show().text(response.message);
                }
            },
            error: function(jqXHR) {
                $('#submit_forgot_password').text('Forgot password').prop('disabled',
                    false);
                var response = $.parseJSON(jqXHR.responseText);
                if (response.message) {
                    toastr.error(response.message);
                }
            }
        });

    });
});
</script>
