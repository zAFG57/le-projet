<?php
    use \Controller\ControllerUser;
    use \Controller\ControllerCsrf;
    use \Controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;

    include_once '../controller/user.php';
    include_once '../controller/csrfConfig.php';
    include_once '../controller/chatProUser.php';
    include_once '../controller/actionManager.php';
    include_once '../model/actionManager.php';

    if (isset($_POST['chatin']) && isset($_POST['userID']) && isset($_POST['csrf_token']) && isset($_POST['action_token'])) {
        $resultRequest = false;
        if (!empty($_POST['chatin'])) {
            session_start();
            if (ControllerActionManager::allowRequestAction($_POST['action_token'], ActionManager::$NEW_MESSAGE_ACTION_TOKEN)) {
                if(isset($_SESSION['userID'])){
                    if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                        if(ControllerUser::isPro(intval($_POST['userID']))) {
                            $resultRequest = ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_SESSION['userID']), intval($_POST['userID'])), htmlspecialchars($_POST['chatin']), $_SESSION['userID']);
                        } else if(ControllerUser::isPro(intval($_SESSION['userID']))) {
                            $resultRequest = ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($_POST['userID']), intval($_SESSION['userID'])), htmlspecialchars($_POST['chatin']), $_SESSION['userID']);
                        }
                    }
                }
            }
        }
        echo json_encode($resultRequest);
    }