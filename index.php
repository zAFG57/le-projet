<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {


    $authorized_pages = array(
        "createAccount" => "view/create_account",
        "createProAccount" => "view/create_professional_account",
        "emailVerification" => "view/email_verification",
        "login" => "view/log_in",    
    );

    if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
        header("Location: {$authorized_pages[$_GET['location']]}");
        die();
    } else {
        header("Location: ./view/log_in");
        exit;
    }
}

$authorized_pages = array(
    "emailVerification" => "view/email_verification",
    "homePage" => "view/home_page",
    "profile" => "view/profile_page",
    "réparation" => "view/réparation",
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[$_GET['location']]}");
    die();
} else {
    header("Location: view/home_page.php");
}