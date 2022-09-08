<?php
namespace Models;

use PDO;
use Exception;

class Event extends Main
{
    public function allAdmin($page = 0, $items_per_page = 5) {
        try {
            $limit = ($page > 1) ? ($page * $items_per_page) - $items_per_page : 0;

            $sql = "SELECT event_id as id, user_id, title as Title, thumbnail as Image, start as Start_at, end as End_at,
             street, housenumber, zipcode, location, createdate as Created_at, 
             updatedate as Updated_at FROM events ORDER BY start LIMIT $limit, $items_per_page";
            $results = self::readsData($sql);

            $sql = "SELECT FOUND_ROWS() as total FROM events";
            $pages = self::countPages($sql, $items_per_page);

            return [$results, $pages];
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }


    public function all($page = 0, $items_per_page = 5) {
        try {
            $limit = ($page > 1) ? ($page * $items_per_page) - $items_per_page : 0;

            $sql = "SELECT event_id as id, user_id, title as Title, thumbnail as Image, start as Start_at, end as End_at,
             street, housenumber, zipcode, location, createdate as Created_at, 
             updatedate as Updated_at FROM events ORDER BY start LIMIT $limit, $items_per_page";
            $results = self::readsData($sql);

            $sql = "SELECT FOUND_ROWS() as total FROM events";
            $pages = self::countPages($sql, $items_per_page);

            return [$results, $pages];
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function thisWeekEvents($limit){

        try{

        $sql = "SELECT event_id as id, user_id, title as Title, thumbnail as Image, start as Start_at, end as End_at,
        street, housenumber, zipcode, location, createdate as Created_at, 
        updatedate as Updated_at FROM events WHERE WEEK(start) = WEEK(now()) AND YEAR(end) = YEAR(now()) ORDER BY start ASC LIMIT $limit";
        $results = self::readsData($sql);

        return $results;

     } catch(Exception $e){
        throw $e->getMessage();
     }

    }

    public function read($id) {
        try {
            $sql = "SELECT * FROM events WHERE event_id = $id";
            $results = self::readData($sql);
            return $results->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function create($user_id, $title, $thumbnail, $startdate, $enddate, $street, $housenumber, $zipcode, $location) {
        try {
            $sql = "INSERT INTO `events` (`event_id`, `title`, `thumbnail`, `start`, `end`, `street`, `housenumber`, `zipcode`, `location`, `createdate`, `user_id`) VALUES (NULL, '{$title}', '{$thumbnail}', '{$startdate}', '{$enddate}', '{$street}', '{$housenumber}', '{$zipcode}', '{$location}', NOW(), '{$user_id}')";
            $results = self::createData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function update($id, $user_id, $startdate, $enddate, $title, $thumbnail, $street, $housenumber, $zipcode, $location) {
        try {
            $sql = "UPDATE `events` SET `user_id` = '{$user_id}', `start` = '{$startdate}', `end` = '{$enddate}',`title` = '{$title}', `thumbnail` = '{$thumbnail}', `street` = '{$street}', `housenumber` = '{$housenumber}', `zipcode` = '{$zipcode}', `location` =  '{$location}', `updatedate` = NOW() WHERE `event_id` = '{$id}'";
            $results = self::updateData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM `events` WHERE `event_id` = '{$id}'";
            $results = self::deleteData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}
