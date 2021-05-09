<?php
session_start();

define("ROOTPATH", __DIR__);


if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {


    $authorized_pages = array(
        "createAccount" => "/view/create_account.php",
        "createProAccount" => "/view/create_professional_account.php",
        "emailVerification" => "/view/email_verification.php",
        "login" => "/view/log_in.php",    
    );

    if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
        header("Location: {$authorized_pages[htmlspecialchars($_GET['location'])]}");
        die();
    } else {
        header("Location: {$authorized_pages['login']}");
        exit;
    }
}

$authorized_pages = array(
    "emailVerification" => "/view/email_verification.php",
    "homePage" => "/view/home_page.php",
    "profile" => "/view/profile.php",
    "chat" => "/view/chat.php"
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[htmlspecialchars($_GET['location'])]}"); 
    die();
} else {
    header("Location: {$authorized_pages['homePage']}");
    exit;
}
