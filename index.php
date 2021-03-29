<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    
    header("Location: ./view/log_in");
    exit;
}

$authorized_pages = array(
    "createAccount" => "view/create_account",
    "createProAccount" => "view/create_professional_account",
    "emailVerification" => "view/email_verification",
    "homePage" => "view/home_page",
    "login" => "view/log_in",
    "homePage" => "view/home_page",
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[$_GET['location']]}");
    die();
} else {
    header("Location: view/home_page.php");
}