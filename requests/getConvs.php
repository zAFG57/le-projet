<?php 
    use \controller\ControllerCsrf;
    use \controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;

    include_once  __DIR__ . '/../controller/csrfConfig.php';
    include_once  __DIR__ . '/../controller/chatProUser.php';
    include_once  __DIR__ . '/../controller/actionManager.php';
    include_once  __DIR__ . '/../model/actionManager.php';

    if (isset($_POST['myIdForConvs']) && isset($_POST['csrf_token']) && isset($_POST['action_token'])) { 
        $resultRequest = false;
        session_start();
        if (ControllerActionManager::allowRequestAction($_POST['action_token'], ActionManager::$GET_CONV_ACTION_TOKEN)) {
            if (isset($_SESSION['userID']) && intval($_POST['myIdForConvs']) === $_SESSION['userID']) {
                if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                    $resultRequest = ControllerChatProUser::displayDiscussions($_SESSION['userID']);
                }
            }
        }
        echo json_encode($resultRequest);
    }