<?php

namespace Controllers;

use Classes\Functions;

class HomeController
{
    public function __construct() {
        $this->Home = new \Models\Home();
        $this->Blog = new \Models\Blog();
        $this->Event = new \Models\Event();
        $this->Display = new \Classes\Display();
    }

    public function about() {
        include('views/pages/about.php');
    }

    public function contact() {
        if($_POST) {
            //Add phpmailer or other shit

            Functions::toast('Message received. We will try to get back asap..', 'info');

            header('location: ' . PATH_URL);
            exit();
        }

        include('views/pages/contact.php');
    }

    public function index() {
        $result = $this->Blog->latestBlogs(2);
        $html = $this->Display->createBlogCard($result, 0, PATH_DIR . '/blog');
        $eventresults = $this->Event->thisWeekEvents(5);
        $event = $this->Display->CreateCardEvent($eventresults, 0);

        include 'views/pages/home.php';
    }
}
