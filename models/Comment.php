<?php
namespace Models;

use Classes\Functions;
use Exception;

class Comment extends Main
{
    public function all($id, $page = 0, $items_per_page = 8) {
        try {
            $limit = ($page > 1) ? ($page * $items_per_page) - $items_per_page : 0;

            $sql = "SELECT comments.id, comments.blog_id, comments.reply_id, comments.created_at, comments.message, users.username FROM comments
                    INNER JOIN users
                    ON comments.user_id = users.id WHERE blog_id = " . $id . " ORDER BY created_at DESC LIMIT " . $limit . ", " . $items_per_page;
            $results = self::readsData($sql);

            $sql = "SELECT FOUND_ROWS() as total FROM comments
                    INNER JOIN users
                    ON comments.user_id = users.id
                    WHERE blog_id = " . $id;

            $pages = array(
                "limit" => $items_per_page,
                "pages" => self::countPages($sql, $items_per_page),
                "current" => $page,
                "items" => self::readsData($sql)->rowCount()
            );

            return [
                "pager" => $pages,
                "results" => $results->fetchAll(\PDO::FETCH_ASSOC)
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function read($id) {
        try {
            $sql = "SELECT * FROM comments WHERE id = $id";
            $results = self::readData($sql);

            return $results->fetch(\PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function create($user_id, $blog_id, $message, $reply_id) {
        try {
            $errors = array();

            if(Functions::isLoggedin($user_id)) {
                $sql = "INSERT INTO `comments` (`message`, `blog_id`, `created_at`, `user_id`, `reply_id`) 
                    VALUES ('{$message}', '{$blog_id}', NOW(), '{$user_id}', NULLIF('{$reply_id}', ''))";
                $result = self::createData($sql);

                return [
                    "id" => $result
                ];
            } else {
                $errors[] = "Currently not loggedin. Please try again later.";
            }

            return (object) [
                'errors' => $errors
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM `comments` WHERE `id` = '{$id}'";
            $results = self::deleteData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
