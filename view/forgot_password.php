<?php require_once('../controller/user.php');

session_start();


if (isset($_GET['h']) && !empty($_GET['h'])) {
    require_once("./forgotPassword/forgotPasswordReceived.php");
} else {
    require_once("./forgotPassword/forgotPasswordSend.php");
}