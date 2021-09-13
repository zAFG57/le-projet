<?php
    namespace Model;

    include_once 'database.php';

    class CreateAccount extends Database {
        protected static function isEmailNotAlreadyUsing($email) {
            return parent::sqlSelect('SELECT user_id FROM users WHERE email=?', 's', $email)->num_rows === 0;
        }

        protected static function addUser($id, $username, $email, $password){
            return parent::sqlInsert('INSERT INTO users VALUES (?, ?, ?, ?, ?, ?, 0, 0, ?, ?)', 'issssssi', $id, $username, password_hash($password, PASSWORD_DEFAULT), $email,'', '','', time());
        }

        protected static function createId() {
            do {
                $id = rand(1, 1000000000);
            } while (self::userIDAlreadyExisting($id));
            return $id;
        }

        protected static function userIDAlreadyExisting($id) {
            return (parent::sqlSelect('SELECT user_id FROM users WHERE user_id=?', 'i', $id)->num_rows === 1);
        }
    }
