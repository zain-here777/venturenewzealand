<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style type="text/css">
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        * {
            margin: 0;
            font-family: sans-serif;
        }

        table {
            border-collapse: collapse !important;
        }
    </style>
</head>

<body>
    <table width="670px" style="margin: auto">
        <thead>
            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td>
                                <div class="logo" style="text-align:center;padding: 50px 0 0;">
                                    <img src="{{asset('assets/images/email/logo_2.png')}}">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>

                                <div class="text_wrapper" style="text-align:center;padding: 60px 30px;">
                                    <h1 style="font-size:2.5rem;font-weight: 800;padding-bottom: 5px;text-transform:capitalize;">Kia Ora {{$name}},
                                    </h1>
                                    <p style="font-size: 1.1rem; min-width: 320px;">You are receiving this email
                                        beacause we received a password reset request for your account. If you did
                                        request a password reset, no further action is required.</p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="lognin_section"
                                    style="text-align:center;position: relative;background-image: url('{{asset('assets/images/email/reset-pwd.png')}}');background-position: bottom center;background-repeat: no-repeat;height: 350px;width: 100%;margin-top: 0px;background-size: 100%;">
                                    <a href="{{$url}}" target="_blank"
                                        style="font-size:1.5rem;background-color: #73be45;text-decoration: none;color: #fff;font-weight: 600;padding: 20px 60px;border-radius: 50px;display:inline-block;width: fit-content;margin: auto;z-index: 11;">Reset
                                        your password</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" style="padding: 30px 10px 0;text-align: center;">
                                <h5
                                    style="font-size: 2.5rem;font-weight: 800;padding-bottom: 5px;color: #72bf44;margin:0">
                                    Need any extra help?</h5>
                                <p style="color: #505050;margin: 5px 0 68px;font-size: 1.1rem;">If you need more support
                                    to get you moving along, feel free to contact the Venture New Zealand team.</p>
                                <p style="color: #505050;font-size: 1.1rem;margin-bottom: 50px;">
                                    Call us on <a href="tel:{{$setting['contactus_phone']}}"
                                        style="color: #72bf44;font-weight: 700;">{{$setting['contactus_phone']}}</a> or
                                    send an email to <a href="mailto:{{$setting['contactus_technical_email']}}"
                                        style="color: #72bf44;font-weight: 700;">{{$setting['contactus_technical_email']}}</a>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="social_icons" style="text-align: center;padding: 30px 0;">
                                    <a href="{{$setting['facebook_url']}}"
                                        style="text-decoration: none;padding: 0 10px;" target="_blank">
                                        <img src="{{asset("assets/images/email/FB.png")}}">
                                    </a>
                                    <a href="{{$setting['instagram_url']}}"
                                        style="text-decoration: none;padding: 0 10px;" target="_blank">
                                        <img src="{{asset("assets/images/email/IG.png")}}">
                                    </a>
                                    <a href="{{$setting['youtube_url']}}" style="text-decoration: none;padding: 0 10px;"
                                        target="_blank">
                                        <img src="{{asset("assets/images/email/YT.png")}}">
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="links">
                                    <a href="{{$setting['page_terms_and_conditions']}}"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                        target="_blank">Terms and Conditions & Privacy Policy</a>
                                    {{-- <a href="javascript:void(0)"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: none;color:#000;"
                                        target="_blank">Privacy Policy</a> --}}
                                    <a href="{{$setting['contact']}}"
                                        style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                        target="_blank">Contact</a>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <table width="100%">
                    </table>
                </td>
            </tr>
        </thead>
    </table>
</body>

</html>
