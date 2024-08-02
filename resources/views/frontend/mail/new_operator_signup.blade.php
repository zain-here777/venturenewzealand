<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
                        
        table {
            border-collapse: collapse !important;
        }
    </style>
    <title>Venture New User</title>
</head>

<body style="background-color: #f7f5fa; margin: 0 !important; padding: 0 !important;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#8cca68" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="680">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px; display: flex;align-items: flex-end; justify-content: center;">
                            <img src="{{asset('assets/images/mail_logo.png')}}" style="width: 300px;margin: 0 auto;">
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
                            <h1 style="font-size: 32px; font-weight: 400; margin: 0;text-align: center;font-weight: 600;">New Operator Registration</h1>
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
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 100px;">Name:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"> {{$detail['name']}}</td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 100px;"> Email:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:10px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"><a href="mailto:{{$detail['email']}}">{{$detail['email']}}</a></td>
                                </tr>
                                <tr>
                                    <th align="left" valign="top" style="padding-left:30px;padding-right:15px;padding-bottom:10px; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px; width: 100px;">Usertype:</th>
                                    <td align="left" valign="top" style="padding-left:15px;padding-right:30px;padding-bottom:30px;font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 25px;"> Operator</td>
                                </tr>
                            </table>
                        </td>
                    </tr>   
                    @include('frontend.mail.email_footer')
                </table>
            </td>
        </tr>
    </table>

</body>

</html>