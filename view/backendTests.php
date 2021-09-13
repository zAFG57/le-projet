<?php 
    use model\user;
    use model\ForgotPassword;
    use model\Login;
    use model\ModifyUsers;
    use model\ServiceManager;
    use model\ChatUsers;
    use model\Lang;
    use model\Search;



    // include_once __DIR__ . '/../model/user.php';
    // include_once __DIR__ . '/../model/forgotPassword.php';
    // include_once __DIR__ . '/../model/login.php';
    // include_once __DIR__ . '/../model/modifyUsers.php';
    // include_once __DIR__ . '/../model/serviceManager.php';
    // include_once __DIR__ . '/../model/chatUsers.php';
    include_once __DIR__ . '/../model/search.php';

    include_once __DIR__ . '/../model/lang.php';
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

        // $sheeeesh = new User(null,'jules.grivot.pelisson@gmail.com');
        // $test = (new ChatUsers(123456));
        // $test->createMessage('Hello World', $sheeeesh->getUserID());
        // // var_dump($test->createService('mondomain', 'monsousdomain', 'montitre', 'madescription'));
        // var_dump($test->getMessages());
        // $resultSearch = (new Search(htmlspecialchars($_GET['query']), (isset($_GET['filter'])) ? $_GET['filter'] : ''))->searchService((isset($_GET['page']) && intval($_GET['page']) && intval($_GET['page']) > 0) ? intval($_GET['page']) : 1);

        $resultSearch = (new Search('monsousdomain'))->getNearestServices(3);

        var_dump($resultSearch);
        // $langue = new Lang('fr');
        // var_dump($langue->getFile()['test']);
    ?> 
</body>
</html>


