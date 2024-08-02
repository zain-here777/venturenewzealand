<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,table,td,a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table {
            border-collapse: collapse !important;
        }
    </style>
    <title>Venture Booking Form</title>
</head>

<body style="background-color: #f7f5fa; margin: 0 !important; padding: 0 !important;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#8cca68" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="680">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px; display: flex;align-items: flex-end; justify-content: center;">
                            <img src="{{ asset(setting('logo') ? 'uploads/' . setting('logo') : 'assets/images/assets/logo.png') }}" style="width: 360px;margin: 0 auto;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#8cca68" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="680">
                    <tr>
                        <td bgcolor="#FEFEFE" align="left" valign="top" style="padding: 30px 30px 20px 30px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; line-height: 48px;">
                            <h1 style="font-size: 32px; font-weight: 400; margin: 0;text-align: center;font-weight: 600;">Hello!</h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f3f2f2" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="680">
                    <tr>
                        <td bgcolor="#FEFEFE" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td colspan="2" style="padding: 0 30px 10px ; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                                        <p style="margin-top: 0; margin-bottom: 15px;font-size: 18px;font-weight: 600;">Your reservation is confirmed. <a href="{{route('home')}}" style="color: #72bf45;text-decoration: none;" target="_blank">{{setting('app_name')}}</a></p>
                                    </td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;">Name:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"> {{$name}}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;"> Email:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"><a href="mailto:gauravmlad@gmail.com">{{$email}}</a></td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;"> Phone number:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"><a href="tel:+{{$phone}}">{{$phone}}</a></td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;">Place name:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"> {{$place}}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;">Address:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">{{$address}}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 150px;">Reservation For:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"> {{$datetime}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 30px 0 90px;">
                            <table cellspacing="0" border="0" cellpadding="0" style="width:100% ;max-width:700px;margin: auto;" class="responsive-tbl">
                                <tr>
                                    <td bgcolor="#FEFEFE" align="left">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" style="padding-left:30px;padding-right:30px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;">
                                                    <h3 style="text-align: center;font-size: 26px;font-weight: 800;">Need more help?</h3>
                                                    <p style="text-align: center;">If you need more support to get you moving along, feel free to contact the support team on <a href="tel:+0800 637242" style="color: #72bf45;text-decoration: none;font-weight: 600;">0800 637242</a> or
                                                        email, <a href="mailto:support@venturenewzealand.co.nz" style="color: #72bf45;text-decoration: none;font-weight: 600;">support@venturenewzealand.co.nz</a></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
