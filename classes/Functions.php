<?php

namespace Classes;

class Functions {
    public static function getAddressByZip($postalCode, $number) {
        try {
            $post = [
                'postalcode' => $postalCode,
                'number' => $number,
            ];

            $ch = curl_init('https://postcodefinder.p02.cldsvc.net/api/addressexpress/address');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            // execute!
            $response = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);

            // do anything you want with your response
            header('Content-type: application/json');
            return $response;
        } catch (\Exception $e) {
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

    public static function sendEmail($to, $content, $subject = 'Email from Martin Garrix', $fromName = 'voltixs.nl', $from = 'webworld@voltixs.nl') {
        $html = '
                <!doctype html>
                <html lang="en">
                  <head>
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Martin Garrix</title>
                    <style>
                        @media only screen and (max-width: 620px) {
                          table[class=body] h1 {
                            font-size: 28px !important;
                            margin-bottom: 10px !important;
                          }
                        
                          table[class=body] p,
                        table[class=body] ul,
                        table[class=body] ol,
                        table[class=body] td,
                        table[class=body] span,
                        table[class=body] a {
                            font-size: 16px !important;
                          }
                        
                          table[class=body] .wrapper,
                        table[class=body] .article {
                            padding: 10px !important;
                          }
                        
                          table[class=body] .content {
                            padding: 0 !important;
                          }
                        
                          table[class=body] .container {
                            padding: 0 !important;
                            width: 100% !important;
                          }
                        
                          table[class=body] .main {
                            border-left-width: 0 !important;
                            border-radius: 0 !important;
                            border-right-width: 0 !important;
                          }
                        
                          table[class=body] .btn table {
                            width: 100% !important;
                          }
                        
                          table[class=body] .btn a {
                            width: 100% !important;
                          }
                        
                          table[class=body] .img-responsive {
                            height: auto !important;
                            max-width: 100% !important;
                            width: auto !important;
                          }
                        }
                        @media all {
                          .ExternalClass {
                            width: 100%;
                          }
                        
                          .ExternalClass,
                        .ExternalClass p,
                        .ExternalClass span,
                        .ExternalClass font,
                        .ExternalClass td,
                        .ExternalClass div {
                            line-height: 100%;
                          }
                        
                          .apple-link a {
                            color: inherit !important;
                            font-family: inherit !important;
                            font-size: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                            text-decoration: none !important;
                          }
                        
                          .btn-primary table td:hover {
                            background-color: #d5075d !important;
                          }
                        
                          .btn-primary a:hover {
                            background-color: #d5075d !important;
                            border-color: #d5075d !important;
                          }
                        }
                        </style>
                  </head>
                  <body style="background-color: #eaebed; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background-color: #eaebed; width: 100%;" width="100%" bgcolor="#eaebed">
                      <tr>
                        <td class="container" style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; max-width: 580px; padding: 10px; width: 580px; Margin: 0 auto;" width="580" valign="top">
                          <div class="content" style="box-sizing: border-box; display: block; Margin: 0 auto; max-width: 580px; padding: 10px;">
                            <table role="presentation" class="main" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; background: #ffffff; border-radius: 3px; width: 100%;" width="100%">
                              <tr>
                                <td class="wrapper" style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 20px;" valign="top">
                                  <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; width: 100%;" width="100%">
                                    <tr>
                                    '. $content .'
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </div>
                        </td>
                      </tr>
                    </table>
                  </body>
                </html>
        ';

        // Set content-type header for sending HTML email
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        // Send email
        if( mail($to, $subject, $html, $headers) ){
            return true;
        }

        return false;
    }

    public static function encrypt($password){
        $salted = SALTHEADER . $password . SALTTRAILER;
        return hash('ripemd160', $salted);
    }

    public static function validateRecaptcha($captcha) {
        try {
            $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode(RECAPTCHA_SECRET) .  '&response=' . urlencode($captcha);
            $response = file_get_contents($url);
            $response = json_decode($response,true);

            if($response["success"]){
                return true;
            }

            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function alertMsg($message, $alert = 'info', $title = null, $button = true)
    {
        $result = "";

        switch (strtolower($alert)) {
            case 'success':
                $alert = "alert-success";
                break;

            case 'error':
                $alert = "alert-danger";
                break;

            case 'warning':
                $alert = "alert-warning";
                break;

            case 'info':
            default:
                $alert = "alert-info";
                break;
        }

        $result .= '<div class="alert ' . $alert . ' alert-dismissible fade show" role="alert">';

        if ($title != null) {
            $result .= '<h5 class="alert-heading">' . $title . '</h5>';
        }

        if ( $button ) {
            $result .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>';
        }

        $result .= $message;

        $result .= '</div>';

        return $result;

    }

    public static function isLoggedin($id = null) {
        if(!empty($_SESSION['user']) && $_SESSION['user']->id) {

            if(!empty($id) && $_SESSION['user']->id != $id) {
                return false;
            }

            return true;
        }

        return false;
    }

    public static function isAdmin() {
        if(!empty($_SESSION['user']) && $_SESSION['user']->admin) {

            if($_SESSION['user']->admin == 1) {
                return true;
            }

        }

        return false;
    }

    public static function toJSON($array) {
        header('Content-type: application/json');
        return json_encode($array);
    }

    public static function toast($message, $type = 'info',  $position = 'toast-bottom-left', $duration = 1000, $onclick = '') {
        $message = "<script type=\"text/javascript\">toast('{$message}', '{$type}', '{$position}', {$duration}, {$onclick})</script>";

        if(isset($_SESSION['toast'])) {
            $_SESSION['toast'] = $_SESSION['toast'] . $message;
        } else {
            $_SESSION['toast'] = $message;
        }

        return $_SESSION['toast'];
    }
}