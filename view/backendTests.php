<?php 
    use model\user;
    use model\ForgotPassword;
    use model\Login;
    use model\ModifyUsers;
    use model\ServiceManager;
    use model\ChatUsers;


    include_once __DIR__ . '/../model/user.php';
    include_once __DIR__ . '/../model/forgotPassword.php';
    include_once __DIR__ . '/../model/login.php';
    include_once __DIR__ . '/../model/modifyUsers.php';
    include_once __DIR__ . '/../model/serviceManager.php';
    include_once __DIR__ . '/../model/chatUsers.php';
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
        $test = (new ChatUsers(123456));
        $test->createMessage('Hello World', $sheeeesh->getUserID());
        // var_dump($test->createService('mondomain', 'monsousdomain', 'montitre', 'madescription'));
        var_dump($test->getMessages());
    ?> 
</body>
</html>


