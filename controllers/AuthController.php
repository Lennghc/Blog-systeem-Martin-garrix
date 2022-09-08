<?php

namespace Controllers;

use Classes\Functions;
use Exception;

class AuthController
{
    public function __construct()
    {
        $this->Display = new \Classes\Display();
        $this->Auth = new \Models\Auth();
    }

     public function authHandlePasswordReset() {
         unset($_SESSION['token']);
         $resetToken = isset($_GET['token']) ? $_GET['token'] : null;

         if ($resetToken) {
             $resultToken = $this->Auth->checkResetToken($resetToken);

             if (!isset($resultToken->errors)) {
                 $_SESSION['resetToken'] = $resultToken['token'];
             } else {
                 Functions::toast($resultToken->errors, 'info');

                 exit;
             }
         }

         $validation = new \Classes\Validation();

         if( $resetToken && $resultToken ) {
             $password = $validation->name('password')->required()->return();
             $validation->name('password_confirmation')->required()->equal($password);
         } else {
             $validation->name('email')->pattern('email')->required();
         }

         $success = $validation->isSuccess();

         if($success) {
             if( $resetToken && $resultToken ) {
                 $this->Auth->resetPassword($success->password, $resultToken['user_id']);
             } else {
                 $this->authCreatePasswordReset($success->email);
             }
         }
     }

     public function authCreatePasswordReset($email) {
         $token = md5(uniqid(mt_rand(), true));
         $create = $this->Auth->createPasswordReset($email, $token);

         if (!isset($create->errors)) {
             Functions::sendEmail($email, '
                     <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;" valign="top">
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hi <strong>'. $create['username'] .'</strong>, here is your email to recover your account.</p>
                        <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Push the button below in order to start the recover process.</p>
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; box-sizing: border-box; width: 100%;" width="100%">
                           <tbody>
                              <tr>
                                 <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;" valign="top">
                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: auto; width: auto;">
                                       <tbody>
                                          <tr>
                                             <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; border-radius: 5px; text-align: center; background-color: #ec0867;" valign="top" align="center" bgcolor="#ec0867">
                                                 <a href="https://'. $_SERVER['SERVER_NAME'] . PATH_DIR . '/auth/passwordreset?token='. $token .'" target="_blank" style="border: solid 1px #ec0867; border-radius: 5px; box-sizing: border-box; cursor: pointer; display: inline-block; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-decoration: none; background-color: #ec0867; border-color: #ec0867; color: #ffffff;">
                                                     Reset password
                                                 </a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                     </td>
                 ', 'Password reset | webworld.voltixs.nl');

             exit;
         }

         echo Functions::toJSON(array(
             'errors' => !empty($create->errors) ? $create->errors : null
         ));
     }


    public function settings() {
        
        if (!isset($_SESSION['user'])) {
            header('location: ' . PATH_URL);
        }

        $results = $this->Auth->read($_SESSION['user']->id);
        $html = $this->Display->createSettingsTable($results);                

        if(isset($_POST['username']) || isset($_POST['email']) || isset($_POST['firstname'])) {
            $this->edituser();
            header('location: ' . $_SERVER['REQUEST_URI']);
        } else {
            include('views/pages/settings.php');  
        }

    }

    public function logout()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        header('location: ' . PATH_URL);
    }

    public function edituser() {
        
        if (!isset($_SESSION['user'])) {
            header('location: ' . PATH_URL);
        }
        
        $results = $this->Auth->read($_SESSION['user']->id);
        
        // take information from database from posted information
        $allResultsUsername = $this->Auth->readAllUsername($_POST['username']);
        $allResultsEmail = $this->Auth->readAllEmail($_POST['email']);

        // does the username or password already exist in the database (return false or true)    
        $taken = false;
        if (!empty($allResultsUsername) || !empty($allResultsEmail)) {

            if ($results['email'] !== $_POST['email']) {
                if (!empty($allResultsEmail)) {
                    // sent already taken notification.
                    Functions::toast('Username or email is already linked to a account.', 'danger');
                    $taken = true;                 
                }
            }              

            if ($results['username'] !== $_POST['username']) {
                if (!empty($allResultsUsername)) {      
                    // sent already taken notification.      
                    Functions::toast('Username or email is already linked to a account.', 'danger');

                    $taken = true;
                }      
            } 
        } 
        
            $data = $_POST;
            $result = $this->Auth->updateUser($data, $_SESSION['user']->id);

            if ($result == true) {
                // sent successfull notification
                Functions::toast('Account details updated', 'success');
            } else {
                // sent fail notification
                $_SESSION['toast'] = 'Something whent wrong try again later';
                Functions::toast('Something whent wrong try again later', 'warning');

            }
       
        

        

    }

    public function login() {

        $validation = new \Classes\Validation();
        $validation->name('email')->pattern('email')->required();
        $validation->name('password')->required()->return();

        $success = $validation->isSuccess();

        if ($success) {
            $result = $this->Auth->login($success->email, $success->password);

            if (!isset($result->errors)) {
                echo Functions::toJSON(array(
                    'username' => $result['username']
                ));

                exit;
            }
        }

        echo Functions::toJSON(array(
            'errors' => !$success ? $validation->result() : (!empty($result->errors) ? $result->errors : null)
        ));
    }

    public function register()
    {
        $validation = new \Classes\Validation();
//        $captcha = $validation->name('g-recaptcha-response')->required()->return();
        $validation->name('email')->pattern('email')->required();
        $validation->name('username')->pattern('alpha')->required();
        $password = $validation->name('password')->required()->return();
        $validation->name('password_confirmation')->required()->equal($password);

        $success = $validation->isSuccess();

        if ($success) {
            $result = $this->Auth->create($success->username, $success->email, $success->password);

            if (!isset($result->errors)) {
                echo Functions::toJSON(array(
                    'id' => $result
                ));

                exit;
            }
        }

        http_response_code(400);

        echo Functions::toJSON(array(
            'errors' => !$success ? $validation->result() : (!empty($result->errors) ? $result->errors : null)
        ));
    }
}
