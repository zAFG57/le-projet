<?php session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../index.php?location='réparation'");
}

if (isset($_GET['query']) && !empty($_GET['query'])) {
    require_once('./home/home_search.php');
} else {
    require_once('./home/home_page.php');
}