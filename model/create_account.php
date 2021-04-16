<?php
require_once('util.php');
require_once('database.php');

class CreateAccount extends Database {
    protected static function isEmailNotAlreadyUsing($email) {
        return parent::sqlSelect('SELECT id FROM users WHERE email=?', 's', $email)->num_rows === 0;
    }

    protected static function addUser($id, $username, $email, $password){
        return parent::sqlInsert('INSERT INTO users VALUES (?, ?, ?, ?, 0, 0, ?)', 'isssi', $id, $username, $email,  password_hash($password, PASSWORD_DEFAULT), time());
    }

    protected static function createId() {
        do {
            $id = rand(1, 10000000000);
        } while (self::idAlreadyExisting($id));
        return $id;
    }

    protected static function idAlreadyExisting($id) {
        return (parent::sqlSelect('SELECT id FROM users WHERE id=?', 'i', $id)->num_rows === 1);
    }
}
