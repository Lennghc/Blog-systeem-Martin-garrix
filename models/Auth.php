<?php

namespace Models;

use Classes\Functions;
use Exception;
use PDO;


class Auth extends Main
{
    public function create($username, $email, $password) {
        try {
            $errors = array();

            $sql = "SELECT * FROM `users` WHERE `username`='{$username}' OR `email`='{$email}'";
            $result = self::readsData($sql);

            if($result->rowCount() > 0) {
                $errors[] = "Username or email is already linked to a account.";
            } else {
                $password = Functions::encrypt($password);
                $sql = "INSERT INTO `users` (`username`, `email`, `password`, `created_at`) VALUES ('{$username}', '{$email}', '{$password}', NOW())";
                $result = self::createData($sql);

                http_response_code(201);

                return $result;
            }

            return (object) [
                'errors' => $errors
            ];
        } catch (Exception $e){
            throw $e;
        }
    }

    public function read($id) {
        try {
            $sql = "SELECT * FROM `users` WHERE id = " . $id;
            $result = self::readsData($sql);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function readAllUsername($username) {
        try {
            $sql = "SELECT * FROM `users` WHERE username = '{$username}'";
            $result = self::readsData($sql);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function readAllEmail($email) {
        try {
            $sql = "SELECT * FROM `users` WHERE email = '{$email}'";
            $result = self::readsData($sql);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateUser($data, $userId) {
        try {
            
            $username = $data['username'];
            $firstname = $data['firstname'];
            $lastname = $data['lastname'];
            $email = $data['email'];
            
            
            $sql = "UPDATE `users` SET `username` = '{$username}', `firstname` = '{$firstname}', `lastname` = '{$lastname}',`email` = '{$email}' WHERE `id` = '{$userId}'";
            $result = self::updateData($sql);

            return true;
        } catch (Exception $e) {
            throw $e;
        }                
    }

     public function update($id, $firstname, $lastname, $email, $street, $city, $housenumber, $zipcode) {
         try {
             $sql = "UPDATE `users` SET firstname = '". $firstname ."', lastname = '". $lastname ."', email = '". $email ."', address_street = '". $street ."', address_city = '". $city ."', address_number = '". $housenumber ."', address_zipcode = '". $zipcode ."', updated_at = NOW()  WHERE id = " . $id;
             $result = self::updateData($sql);

             return $result;
         } catch (Exception $e) {
             throw $e;
         }
     }

    public function delete($id) {
        try {
            $sql = "DELETE FROM `users` WHERE `id` = '{$id}'";
            $results = self::deleteData($sql);

            return $results;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function login($email, $password) {
        try {
            $errors = array();
            $password = Functions::encrypt($password);

            $sql = "SELECT * FROM `users` WHERE email = '{$email}' AND password = '{$password}'";
            $result = self::readsData($sql);
            $result = $result->fetch(PDO::FETCH_ASSOC);

            if( !$result ) {
                $errors[] = "Password or email are incorrect.";
            } else {
                $_SESSION['user'] = (object)array(
                    'id' => $result['id'],
                    'username' => $result['username'],
                    'admin' => $result['admin'],
                );

                setcookie('user', json_encode($_SESSION['user']));

                return $result;
            }

            http_response_code(401);

            return (object) [
                'errors' => $errors
            ];
        } catch (Exception $e){
            throw $e;
        }
    }

     public function createPasswordReset($email, $resetToken) {
         try {
             $errors = array();

             $sql = "SELECT id, username FROM `users` WHERE email = '{$email}'";
             $user = self::readsData($sql);
             $user = $user->fetch(PDO::FETCH_ASSOC);

             if( $user ) {
                 $sql = "SELECT created_at, user_id FROM `password_resets` WHERE user_id = {$user['id']} AND created_at >= NOW() - INTERVAL 1 DAY";
                 $passwordReset = self::readsData($sql);
                 $passwordReset = $passwordReset->fetch(PDO::FETCH_ASSOC);

                 if( !$passwordReset ) {
                     $sql = "INSERT INTO `password_resets` (`user_id`, `token`) VALUES ('{$user['id']}', '{$resetToken}')";
                     $create = self::createData($sql);

                     if($create) {
                         http_response_code(201);

                         return $user;
                     }

                     $errors[] = "Something went wrong. Please try again later.";
                 }  else {
                     $errors[] = "You already requested a password reset recently.";
                 }
             } else {
                 $errors[] = "Email incorrect. No user found registrated";
             }

             http_response_code(400);

             return (object) [
                 'errors' => $errors
             ];

         } catch (Exception $e){
             throw $e;
         }
     }

     public function resetPassword($password, $userId) {
         try {
             $errors = array();
             $password = Functions::encrypt($password);

             $sql = "UPDATE `users` SET password = '{$password}' WHERE id = {$userId}";
             $result = self::updateData($sql);

             if( $result ) {
                 $sql = "DELETE FROM `password_resets` WHERE user_id = {$userId}";
                 $result = self::deleteData($sql);
                 http_response_code(204);

                 return $result;
             } else {
                 $errors[] = "Something went wrong. Please try again later.";
             }

             return (object) [
                 'errors' => $errors
             ];
         } catch (Exception $e){
             throw $e;
         }
     }

     public function checkResetToken($token) {
         try {
             $errors = array();

             $sql = "SELECT user_id, token FROM `password_resets` WHERE token = '{$token}'";
             $result = self::readsData($sql);
             $result = $result->fetch(PDO::FETCH_ASSOC);

             if( $result ) {
                 return $result;
             } else {
                 $errors[] = "Your reset token is incorrect or expired.";
             }

             http_response_code(400);

             return (object) [
                 'errors' => $errors
             ];

         } catch (Exception $e){
             throw $e;
         }
     }
}