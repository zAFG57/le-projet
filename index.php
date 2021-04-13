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
        header("Location: {$authorized_pages['login']}");
        exit;
    }
}

$authorized_pages = array(
    "emailVerification" => "view/email_verification",
    "homePage" => "view/home_page",
    "profile" => "view/profile_page",
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[$_GET['location']]}");
    die();
} else {
    header("Location: {$authorized_pages['homePage']}");
    exit;
}
