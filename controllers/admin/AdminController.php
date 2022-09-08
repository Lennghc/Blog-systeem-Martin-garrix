<?php

namespace Controllers\Admin;

use Exception;
use Classes\Functions;

class AdminController {
    public function __construct() {
        $this->BlogsController = new \Controllers\Admin\BlogsController();
        $this->EventsController = new \Controllers\Admin\EventsController();
        $this->UsersController = new \Controllers\Admin\UsersController();

    }

    public function handleRequest() {
        try{

            $op = isset($_GET['op']) ? $_GET['op'] : '';

            switch ($op) {
                default:
                    $this->collectDashboard();
                    break;
            }

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function collectDashboard(){

        if ($_SESSION['user']->admin == 1) {

            include 'views/admin/layout/index.php';

        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }


    }



}