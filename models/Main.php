<?php
namespace Models;

class Main extends DataHandler
{
    public function __construct() {
            parent::__construct(DB_HOST, "mysql", DB_NAME, DB_USER, DB_PASS);
    }

    public function __destruct() {
        parent::__destruct($dbh = null);
    }

}