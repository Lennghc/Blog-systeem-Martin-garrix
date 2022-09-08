<?php

namespace Controllers\Admin;

use Exception;
use Classes\Functions;

class EventsController
{
    public function __construct()
    {
        $this->Event = new \Models\Event();
        $this->Display = new \Classes\Display();
        $this->number = !empty($_GET['number']) ? $_GET['number'] : 1;
    }

    public function handleRequest()
    {
        try {


            isset($_GET['con']) === 'admin' ? $_GET['con'] : $_GET['con'] = 'admin';

            $op = isset($_GET['page']) ? $_GET['page'] : '';

            switch ($op) {
                case 'create':
                    $this->create();
                    break;

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


            $res = $this->Event->allAdmin($this->number, 5);

            $nav = $this->Display->PageNavigation($res[1], $this->number);

            $table = $this->Display->CreateTable($res[0], true, true, false, 'eventtable');

            include 'views/admin/events/index.php';
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function create()
    {
        if ($_SESSION['user']->admin == 1) {

            $user_id = $_SESSION['user']->id;
            $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
            $thumbnail = isset($_REQUEST['thumbnail']) ? $_REQUEST['thumbnail'] : 'garrix.jp';
            $startdate = isset($_REQUEST['startdate']) ? $_REQUEST['startdate'] : null;
            $enddate = isset($_REQUEST['enddate']) ? $_REQUEST['enddate'] : null;
            $street = isset($_REQUEST['street']) ? $_REQUEST['street'] : null;
            $houseNumber = isset($_REQUEST['housenumber']) ? $_REQUEST['housenumber'] : null;
            $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : null;
            $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : null;

            if (isset($_REQUEST['createEvent'])) {

                $create =  $this->Event->create($user_id, $title, $thumbnail, $startdate, $enddate, $street, $houseNumber, $zipcode, $location);

                if (isset($create)) {

                    Functions::toast('Event with success created', 'success');
                    header('Location: ' . PATH_DIR . '/admin/events');

                }
            }
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function update()
    {

        if ($_SESSION['user']->admin == 1) {


            $user_id = $_SESSION['user']->id;
            $id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;
            $title = isset($_REQUEST['title']) ? $_REQUEST['title'] : null;
            $thumbnail = isset($_REQUEST['thumbnail']) ? $_REQUEST['thumbnail'] : null;
            $startdate = isset($_REQUEST['startdate']) ? $_REQUEST['startdate'] : null;
            $enddate = isset($_REQUEST['enddate']) ? $_REQUEST['enddate'] : null;
            $street = isset($_REQUEST['street']) ? $_REQUEST['street'] : null;
            $houseNumber = isset($_REQUEST['housenumber']) ? $_REQUEST['housenumber'] : null;
            $zipcode = isset($_REQUEST['zipcode']) ? $_REQUEST['zipcode'] : null;
            $location = isset($_REQUEST['location']) ? $_REQUEST['location'] : null;

            if (isset($_REQUEST['updatedata'])) {

                $edit = $this->Event->update($id, $user_id, $startdate, $enddate, $title, $thumbnail, $street, $houseNumber, $zipcode, $location);


                if (isset($edit)) {

                    Functions::toast('Event with success updated', 'success');
                    header("Location: " . PATH_DIR . "/admin/events");

                }
            }
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }

    public function delete()
    {

        if ($_SESSION['user']->admin == 1) {


            $id = isset($_REQUEST['event_id']) ? $_REQUEST['event_id'] : null;

            if (isset($_REQUEST['deleteEvent'])) {

                $delete = $this->Event->delete($id);

                if (isset($delete)) {

                    Functions::toast('Event with success removed', 'success');
                    header("Location: " . PATH_DIR . "/admin/events");

                }
            }
        } else {

            Functions::toast('Not available');
            header('location: ' . PATH_URL);
        }
    }
}
