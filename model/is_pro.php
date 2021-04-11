<?php 
require_once('util.php');
session_start();


function isPro(){
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || isset($_SESSION['userID']) || is_int($_SESSION['userID'])) {
        return false;
    } else {
        if($db) {
            $res = sqlSelect($db, 'SELECT users.pro, users.verified FROM users WHERE users.id' ,'i', $_SESSION['userID']);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro['users.verified']) {
                    if($userPro['users.pro'] === 1){
                        return true;
                    } else {
                        return false;
                    }

                } else {
                    echo -2;
                }

            } else {
                echo -1;
                return;
            }
        }
    }
}