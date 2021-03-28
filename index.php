<?php
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    
    header("Location: ./view/log_in");
    exit;
}
 
echo $_SESSION['loggedin'];
header("Location: ./view/home_page");
die();