<?php 

require_once('../controller/user.php');

session_start();


if (isset($_GET['h']) && !empty($_GET['h']) && strlen($_GET['h'])>5) {
    require_once("./forgotPassword/forgotPasswordReceived.php");
} else {
    require_once("./forgotPassword/forgotPasswordSend.php");
}