<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <!--[if mso]>
    <style>
        table {
            border-collapse: collapse;
            border-spacing: 0;
            border: none;
            margin: 0;
        }

        div, td {
            padding: 0;
        }

        div {
            margin: 0 !important;
        }
    </style>
    <noscript>
        <xml>
            <o:OfficeDocumentSettings>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    </noscript>
    <![endif]-->
    <style>
        table, td, div, h1, p {
            font-family: Arial, sans-serif;
        }

        @media screen and (max-width: 530px) {
            .unsub {
                display: block;
                padding: 8px;
                margin-top: 14px;
                border-radius: 6px;
                background-color: #555555;
                text-decoration: none !important;
                font-weight: bold;
            }

            .col-lge {
                max-width: 100% !important;
            }
        }

        @media screen and (min-width: 531px) {
            .col-sml {
                max-width: 27% !important;
            }

            .col-lge {
                max-width: 73% !important;
            }
        }
    </style>
</head>
<body style="margin:0;padding:0;word-spacing:normal;background-color:#6c757d;">
<div role="article" aria-roledescription="email" lang="en"
     style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#939297;">
    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
        <tr>
            <td align="center" style="padding:0;padding-bottom: 50px;">
                <!--[if mso]>
                <table role="presentation" align="center" style="width:600px;">
                    <tr>
                        <td>
                <![endif]-->
                <table role="presentation"
                       style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                    <tr>
                        <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                            <a href="http://businessbrainz.com/" style="text-decoration:none;"><img
                                    src="https://businessbrainz.com/wp-content/uploads/2021/08/business_brainz_logo_deliverables-07-01-removebg-preview-1-150x150.png"
                                    width="165" alt="Logo"
                                    style="width:80%;max-width:165px;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;background-color:#ffffff;">
                            <h1 style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;color:#013f59;">
                                A client scheduled a meeting!</h1>
                            <p style="margin:0;">Dear Admin,</p>
                            <p style="margin:0;">A client has scheduled a meeting with additional information. The details are as follows</p>

                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 30px;background-color:#ffffff;">
                            <table>
                                <tr style="margin-bottom: 7px;">
                                    <td>Email:</td>
                                    <td><?php
                                        echo $email ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Company Name:</td>
                                    <td><?php
                                        echo $company_name ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Website:</td>
                                    <td><?php
                                        echo $website ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Client Role:</td>
                                    <td><?php
                                        echo $client_role ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Winning Amount:</td>
                                    <td><?php
                                        echo $winning_amount ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Requirement Sector:</td>
                                    <td><?php
                                        echo $requirement_sector ?></td>
                                </tr>
                                <tr style="margin-bottom: 7px;">
                                    <td>Reason for Appointment:</td>
                                    <td><?php
                                        foreach($reason_for_appointment as $reason){
                                            echo $reason . "<br>";
                                        }
                                        ?></td>
                                </tr>

                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;background-color:#ffffff;">
                            <small style="margin:0;">The email has been generated via the web system.</small>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:30px;text-align:center;font-size:12px;background-color:#013f59;color:#cccccc;">
                            <p style="margin:0;font-size:14px;line-height:20px;">Copyright &copy; Business Brainz, <?php echo date("Y") ?><br>
                        </td>
                    </tr>
                </table>
                <!--[if mso]>
                </td>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </table>
</div>
</body>
</html>