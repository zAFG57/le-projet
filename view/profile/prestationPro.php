<?php
    use Model\User;

    include_once __DIR__ . '/../../model/user.php';

    // if ($userForProfile === new User($_SESSION['userID'])) {
        if (isset($_GET['addService'])) {
            // echo 'test';
            require_once __DIR__ . '/addPrestationPro.php';
        } else {
            // echo 'test';
            require_once __DIR__ . '/displaypro.php';
        }
    // } else {
    //     echo 'tqzdqzdest';
    // }