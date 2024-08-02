<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
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

<body data-new-gr-c-s-check-loaded="14.1047.0" data-gr-ext-installed="">
    <table width="640px" style="margin: auto">
        <thead>
            <tr>
                <td>
                    <table width="100%">
                        <tbody>
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
                                        <h1 style="color:#000;font-size:2.5rem;font-weight: 800;padding-bottom: 5px;">Welcome to
                                            Venture NZ!</h1>
                                        <p style="color:#000;font-size: 1.1rem; min-width: 320px;">
                                            We're excited to have you onboard. Login to your account to start advertising your company and all your fantastic products!</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="lognin_section"
                                        style="text-align: center;position: relative;background-image:url('{{asset("assets/images/email/bg_2.png")}}');background-position: bottom
                                        center;background-repeat: no-repeat;height: 328px;width: 100%;margin-top:
                                        0px;background-size: 100%;">
                                        <a href="{{url('/')}}" target="_blank"
                                            style="color:#000;font-size:1.5rem;background-color: #73be45;text-decoration: none;color: #fff;font-weight: 600;padding: 20px 60px;border-radius: 50px;display: inline-block;width: fit-content;margin: auto;z-index: 11;">Log in</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="padding: 30px 10px 0;">
                                    <p style="color:#000;padding-bottom: 10px;">We are excited to have you onboard!</p>
                                    <p style="color:#000;padding-bottom: 10px">Venture New Zealand was created to give New
                                        Zealanders direction in their travels and we want your company to be at the
                                        forefront of their mind.</p>
                                    <p style="color:#000; padding-bottom: 10px">We have a few pointers for you so that you can get
                                        the most of having your company profile on the Venture New Zealand directory.
                                    </p>
                                    <ul>
                                        <li style="color:#000;">
                                            <p style="color:#000;display: flex;margin-bottom: 7px;margin-top: 15px;">
                                                Fill out as much information in your profile as possible.</p>
                                        </li>
                                        <li style="color:#000;">
                                            <p style="color:#000;display: flex;margin-bottom: 7px;">Make sure you have nice imagery- Remember it's all about attraction.</p>
                                        </li>
                                        <li style="color:#000;">
                                            <p style="color:#000;display: flex;margin-bottom: 7px;">
                                                Feature products- Every New Zealander loves a deal and the more you sell the better.
                                              Remember we don't take commission, what you see is what you get!
                                          </p>
                                        </li>
                                        <li style="color:#000;">
                                            <p style="color:#000; display: flex;margin-bottom: 7px;">
                                                We are sending you out your window stickers with the QR code for Venture rewards.Please attach these to the front window or somewhere visible.
                                              </p>
                                        </li>

                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="social_icons" style="text-align: center;padding: 30px 0;">
                                        <a href="{{$social_media_link['facebook_url']}}"
                                            style="text-decoration: none;padding: 0 10px;" target="_blank">
                                            <img src="{{asset("assets/images/email/FB.png")}}">
                                        </a>
                                        <a href="{{$social_media_link['instagram_url']}}"
                                            style="text-decoration: none;padding: 0 10px;" target="_blank">
                                            <img src="{{asset("assets/images/email/IG.png")}}">
                                        </a>
                                        <a href="{{$social_media_link['youtube_url']}}"
                                            style="text-decoration: none;padding: 0 10px;" target="_blank">
                                            <img src="{{asset("assets/images/email/YT.png")}}">
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="links">
                                        <a href="{{url('page/terms-and-conditions')}}"
                                            style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                            target="_blank">Terms and Conditions</a>
                                        <a href="{{url('page/contact')}}"
                                            style="font-size: .9rem; display: block;padding-bottom: 5px; text-align: center;text-decoration: underline;color:#000;"
                                            target="_blank">Contact</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="footer_link">
                                        <p style="color:#000;text-align:center;padding:30px 0;font-size: .9rem;">Don’t want to
                                            receive these emails?<br><a href="javascript:void(0)"
                                                style="color:#72bf44;">Click here to unsubscribe.</a></p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%">
                    </table>
                </td>
            </tr>
        </thead>
    </table>
</body>

</html>
