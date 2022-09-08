<?php
namespace Models;

use Exception;
use PDO;

class Blog extends Main
{
    public function latestBlogs($limit) {
        try {
            $sql = "SELECT id, user_id, title, content, created_at, updated_at, thumbnail FROM blog ORDER BY created_at DESC  LIMIT " . $limit;
            $results = self::readsData($sql);

            return [$results, null];
        } catch (Exception $e) {
            throw  $e;
        }
    }

    public function all( $page = 1 , $items_per_page = 8 ) {
        try {
            $limit = ($page > 1) ? ($page * $items_per_page) - $items_per_page : 0;

            $sql = "SELECT FOUND_ROWS() as total FROM blog";
            $pages = self::countPages($sql, $items_per_page);

            $sql = "SELECT id, user_id, title, content, created_at, updated_at, thumbnail FROM blog ORDER BY created_at DESC  LIMIT " . $limit . ", " . $items_per_page;
            $results = self::readsData($sql);

            return [$results, $pages];
        } catch (Exception $e) {
            throw  $e;
        }
    }

    public function read($id) {
        try {
            $sql = "SELECT * FROM blog WHERE id = $id";
            $results = self::readData($sql);

            return $results->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw  $e;
        }
    }

    public function create($user_id, $content, $title, $thumbnail) {
        try {
            $sql = "INSERT INTO `blog` (`content`, `title`, `created_at`, `user_id`, `thumbnail`) VALUES ('{$content}', '{$title}', NOW(), '{$user_id}', '{$thumbnail}')";
            $results = self::createData($sql);
            return $results;
        } catch (Exception $e) {
            throw  $e;
        }
    }

    public function update($id, $user_id, $content, $title, $thumbnail) {
        try {
            $sql = "UPDATE `blog` SET `user_id` = '{$user_id}', `content` = '{$content}', `title` = '{$title}', `thumbnail` = '{$thumbnail}', `updated_at` = NOW() WHERE `id` = '{$id}'";
            $results = self::updateData($sql);
            return $results;
        } catch (Exception $e) {
            throw  $e;
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM `blog` WHERE `id` = '{$id}'";
            $results = self::deleteData($sql);

            return $results;
        } catch (Exception $e) {
            throw  $e;
        }
    }
}
