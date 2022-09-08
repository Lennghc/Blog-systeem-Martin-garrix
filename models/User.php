<?php

namespace Models;

use Exception;

class User extends Main
{

    public function all($page = 0, $items_per_page = 8) {
        try {
            $limit = ($page > 1) ? ($page * $items_per_page) - $items_per_page : 0;

            $sql = "SELECT * FROM users ORDER BY id LIMIT $limit, $items_per_page";
            $results = self::readsData($sql);

            $sql = "SELECT FOUND_ROWS() as total FROM users";
            $pages = self::countPages($sql, $items_per_page);

            return [$results, $pages];
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    public function update($id, $username, $firstname, $lastname, $email, $password, $confirmpassword, $role) {
        try {
            $sql = "UPDATE `users` SET `username` = '{$username}', `firstname` = '{$firstname}', `lastname` = '{$lastname}',`email` = '{$email}', `password` = '{$password}', `admin` = '{$role}' ,`updated_at` = NOW() WHERE `id` = '{$id}'";
            $results = self::updateData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }


    public function delete($id) {
        try {

            $sql = "DELETE FROM `users` WHERE `id` = {$id}";
            $results = self::deleteData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}
