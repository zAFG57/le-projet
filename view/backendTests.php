<?php 
    use model\user;
    use model\ForgotPassword;
    use model\Login;
    use model\ModifyUsers;

    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../model/forgotPassword.php';
    include_once __DIR__ . '/../model/login.php';
    include_once __DIR__ . '/../model/modifyUsers.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        // echo new User($userID = 124);
        // $user = new User($userID = 124);
        // var_dump($user);
        // var_dump((new User($userID = 124))->getUserID());

        $sheeeesh = new User(null,'jules.grivot.pelisson@gmail.com');
        $test = new ModifyUsers(null,null, $sheeeesh);
        var_dump($test->getAttempts());
    ?> 
</body>
</html>


