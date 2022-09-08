<?php

namespace Controllers\Admin;

use Exception;
use Classes\Functions;


class UsersController
{
    public function __construct()
    {
        $this->User = new \Models\User();
        $this->Display = new \classes\Display();
        $this->number = !empty($_GET['number']) ? $_GET['number'] : 1;
    }
    public function __destruct()
    {
    }
    public function handleRequest()
    {
        try {


            isset($_GET['con']) === 'admin' ? $_GET['con'] : $_GET['con'] = 'admin';

            $op = isset($_GET['page']) ? $_GET['page'] : '';

            switch ($op) {
                case 'update':
                    $this->update();
                    break;

                case 'delete':
                    $this->delete();
                    break;

                default:
                    $this->index();
                    break;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function index()
    {

        if ($_SESSION['user']->admin == 1) {

            $res = $this->User->all($this->number, 5);

            $nav = $this->Display->PageNavigation($res[1], $this->number);

            $table = $this->Display->CreateTable($res[0], true, true, false, 'userstable');

            include 'views/admin/users/index.php';
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function update() {

        if ($_SESSION['user']->admin == 1) {

                $id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : null;
                $username = isset($_REQUEST['username']) ? $_REQUEST['username'] : null;
                $firstname = isset($_REQUEST['firstname']) ? $_REQUEST['firstname'] : null;
                $lastname = isset($_REQUEST['lastname']) ? $_REQUEST['lastname'] : null;
                $email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
                $role = isset($_REQUEST['role']) ? $_REQUEST['role'] : null;
                $password = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;
                $confirmpassword = isset($_REQUEST['confirmpassword']) ? $_REQUEST['confirmpassword'] : null;

                if (isset($_REQUEST['updatedata'])) {

                    $edit = $this->User->update($id, $username, $firstname, $lastname, $email, $password, $confirmpassword, $role);


                    if (isset($edit)) {

                        Functions::toast('User with success updated', 'success');
                        header("Location: " . PATH_DIR . "/admin/users");
                    }

            } else {

                Functions::toast('Not available');
                header('location: ' . PATH_URL);
            }
        }
    }

    public function delete() {

        if ($_SESSION['user']->admin == 1) {

            $id = isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : null;

            if (isset($_REQUEST['deleteUser'])) {

                if ($_SESSION['userid'] === $id) {
                    $delete = 'You can\'t delete yourself';
                } else {

                    $delete = $this->User->delete($id);
                }
                if (isset($delete)) {

                    Functions::toast('User with success removed', 'success');
                    header("Location: " . PATH_DIR . "/admin/users");

                }
            }
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }
}
