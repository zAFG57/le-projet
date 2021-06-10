<?php 
    namespace Model;

    include_once 'database.php';

    class  Login extends Database {
        
        protected static function userExisting($email) {
            return parent::sqlSelect('SELECT id FROM users WHERE email=?', 's', $email)->num_rows === 1;
        }

        protected static function isMaxLoginAttemptsAchevied($email, $ip){
            return parent::sqlSelect('SELECT COUNT(loginattempts.userId) FROM users LEFT JOIN loginattempts ON users.id = userId AND timestamp>? AND ip=? WHERE email=? GROUP BY users.id','iss', time() - 60*60, $ip, $email)->fetch_assoc()['COUNT(loginattempts.userId)'] >= parent::$MAX_LOGIN_ATTEMPTS_PER_HOUR;   
        }

        protected static function isCorrectPassword($email, $password) {
            return password_verify($password, parent::sqlSelect('SELECT password FROM users WHERE email=?','s', $email)->fetch_assoc()['password']);
        }

        protected static function isVerified($email){
            return parent::sqlSelect('SELECT verified FROM users WHERE email=?','s', $email)->fetch_assoc()['verified'];
        }

        protected static function suppAttempts($id, $ip){
            return parent::sqlUpdate('DELETE FROM loginattempts WHERE userId=? AND ip=?', 'is', $id, $ip);
        }

        protected static function getId($email) {
            return parent::sqlSelect('SELECT id FROM users WHERE email=?','s', $email)->fetch_assoc()['id'];
        }

        protected static function createLoginAttempt($id) {
            return parent::sqlInsert('INSERT INTO loginattempts VALUES (NULL, ?, ?, ?)', 'isi', $id, $_SERVER['REMOTE_ADDR'], time());
        }   

        protected static function setSessionVariables($email) {
            $_SESSION['loggedin'] = true;
            $_SESSION['userID'] = self::getId($email);
        }
    }



