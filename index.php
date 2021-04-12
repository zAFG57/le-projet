<<<<<<< HEAD
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
    "isPro" => "model/is_pro"
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[$_GET['location']]}");
    die();
} else {
    header("Location: {$authorized_pages['homePage']}");
    exit;
}
=======
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
    "isPro" => "model/is_pro"
);

if(isset($_GET['location']) && isset($authorized_pages[$_GET['location']])){
    header("Location: {$authorized_pages[$_GET['location']]}");
    die();
} else {
    header("Location: {$authorized_pages['homePage']}");
    exit;
}
>>>>>>> e15dc6e8c5762f944feffb3300714a4f6e3710b4
