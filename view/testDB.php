<?php 
    require_once('../model/database.php');
    require_once('../model/User.php');
    session_start();


    // $db = new Database;

    // var_dump($db::$db);

    // var_dump($db::sqlSelect('SELECT * FROM users'));

var_dump($_SESSION['userID']);
$usr = new User($_SESSION['userID']);
var_dump($usr->getInfoUser());
var_dump($usr->isPro());
var_dump($usr->isAdmin());

