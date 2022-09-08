<?php

namespace Controllers;

class EventController
{
    protected $page;

    public function __construct() {
        $this->Event = new \Models\Event();
        $this->Display = new \Classes\Display();
        $this->page = !empty($_GET['page']) ? $_GET['page'] : 0;
    }

    public function index() {
        $result = $this->Event->all($this->page);
        $html = $this->Display->CreateCardEvent($result[0],0,true,true);

        include('views/event/index.php');
    }

}
