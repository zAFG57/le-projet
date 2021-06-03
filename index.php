<?php
    session_start();

    define("ROOTPATH", __DIR__);


    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {


        $authorized_pages = array(
            "createAccount" => "/view/create_account.php",
            "createProAccount" => "/view/create_professional_account.php",
            "emailVerification" => "/view/email_verification.php",
            "login" => "/view/log_in.php",  
            "homePage" => "/view/home.php"  
        );

        if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
            header("Location: {$authorized_pages[htmlspecialchars($_GET['location'])]}");
            die();
        } else {
            header("Location: {$authorized_pages['homePage']}");
            exit;
        }
    }

    $authorized_pages = array(
        "emailVerification" => "/view/email_verification.php",
        "homePage" => "/view/home.php",
        "profile" => "/view/profile.php",
        "chat" => "/view/chat.php"
    );

    $authorized_get = array(
        "profile" => "user"
    );

    if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
        echo $_GET[(array_key_exists($authorized_pages[htmlspecialchars($_GET['location'])])) ?  :];
        // header("Location: {$authorized_pages[htmlspecialchars($_GET['location'])]}"); 
        die();
    } else {
        header("Location: {$authorized_pages['homePage']}");
        exit;
    }
