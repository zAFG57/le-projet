<?php 
require_once('util.php');
session_start();


function isPro(){
    // echo is_int($_SESSION['userID']);
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) == 1 && $_SESSION['userID'] > 0) {
        $db = connect();
        if($db) {
            $res = sqlSelect($db, 'SELECT users.pro, users.verified FROM users WHERE users.id = ?' ,'i', $_SESSION['userID']);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro['verified']) {
                    if($userPro['pro'] === 1){
                        return true;
                    }
                }
            }
        }
    }
    return false;
}


function isConnected(){
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) == 1 && $_SESSION['userID'] > 0) {
        return true;
    }
    return false;
}


function getInfoUser() {
    if (isConnected()) {
        $db = connect();
        if($db) {
            $res = sqlSelect($db, 'SELECT ville, objets_reparables,note, username FROM users INNER JOIN pro_users ON users.id = pro_users.id WHERE users.id = ?' ,'i',$_SESSION['userID']);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro) {
                    return $userPro;  
                }
            }
        }
    }
    return -1;
}
