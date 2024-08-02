@extends('frontend.layouts.template')
@section('main')
<main id="main" class="site-main">
    <div class="register-form popup-form">
        <div class="container">
            <div class="dialog-wrapper">
                <h5>Operator Sign Up</h5>
                {{-- @if($errors->any()) --}}
                {{-- {{$errors}} --}}
                {{-- {{ implode('', $errors->all('<div>:message</div>')) }} --}}
                {{-- @endif --}}
                <form class="form-sign form-content" action="{{route('register')}}" method="post">
                    @csrf
                    {{-- <p class="choose-or"><span>{{__('Or')}}</span></p> --}}
                    <small class="form-text text-danger golo-d-none" id="register_error">error!</small>
                    <small class="form-text text-success golo-d-none" id="register_success"></small>
                    <div class="form_field">
                        <div class="field-input">
                            <input type="text" id="register_name" name="name" placeholder="Full Name" required>
                            @if($errors->has('name'))
                            <small class="form-text text-danger golo-d-none"
                                style="display: inline;">{{$errors->first('name')}}</small>
                            @endif
                        </div>
                        <div class="field-input">
                            <input type="email" id="register_email" name="email" placeholder="Email" required>
                            @if($errors->has('email'))
                            <small class="form-text text-danger golo-d-none"
                                style="display: inline;">{{$errors->first('email')}}</small>
                            @endif
                        </div>
                        <div class="field-input">
                            <input type="password" id="register_password" name="password" placeholder="Password"
                                required>
                            @if($errors->has('password'))
                            <small class="form-text text-danger golo-d-none"
                                style="display: inline;">{{$errors->first('password')}}</small>
                            @endif
                        </div>
                        <div class="field-input">
                            <input type="password" id="register_password_confirmation" name="password_confirmation"
                                placeholder="Confirm Password" required>
                            @if($errors->has('password_confirmation'))
                            <small class="form-text text-danger golo-d-none"
                                style="display: inline;">{{$errors->first('password_confirmation')}}</small>
                            @endif
                        </div>
                        <input type="hidden" id="user_type" name="user_type" value="2">
                    </div>
                    <div class="form-group mb-2">
                        <div class="col-md-6">
                            <div class="form-group captcha" style="margin-left: 0px;">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                                @if($errors->has('g-recaptcha-response'))
                                <small class="form-text text-danger golo-d-none"
                                    style="display: inline;">{{$errors->first('g-recaptcha-response')}}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="field-check">
                        <label for="accept">
                            <input type="checkbox" id="accept" checked required>
                            Accept the <a title="Terms" href="{{route('page_terms_and_conditions')}}">Terms and
                                Conditions & Privacy Policy</a>
                            <span class="checkmark">
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="6" viewBox="0 0 8 6">
                                    <path fill="#FFF" fill-rule="nonzero"
                                        d="M2.166 4.444L.768 3.047 0 3.815 1.844 5.66l.002-.002.337.337L7.389.788 6.605.005z" />
                                </svg>
                            </span>
                        </label>
                    </div>
                    <button type="submit" class="gl-button btn button w-100" id="submit_register">{{__('Sign
                        Up')}}</button>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
