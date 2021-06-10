<?php
    namespace verification;

    use \Controller\ControllerUser;
    use \Controller\ControllerCsrf;
    use \Controller\ControllerChatProUser;
    use \Controller\ControllerActionManager;
    use \model\ActionManager;

    include_once __DIR__ . '/../controller/user.php';
    include_once __DIR__ . '/../controller/csrfConfig.php';
    include_once __DIR__ . '/../controller/chatProUser.php';
    include_once __DIR__ . '/../controller/actionManager.php';
    include_once __DIR__ . '/../model/actionManager.php';

    if (isset($_POST['chatin']) && isset($_POST['userID']) && isset($_POST['csrf_token'])) {
        if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
            session_start();
            messageVerification::messageVerification($_POST['chatin'], $_SESSION['userID'], $_POST['userID']);
        }
    }

    class MessageVerification {
        public static function messageVerification($entry, $myUserID, $userIDRececer) {
            $resultRequest = false;
            if (!empty($entry)) {
                // if (ControllerActionManager::allowRequestAction($_POST['action_token'], ActionManager::$NEW_MESSAGE_ACTION_TOKEN)) {
                    if(isset($userID)){
                        // if (ControllerCsrf::validateCsrfToken($_POST['csrf_token'])) {
                            if(ControllerUser::isPro(intval($userID))) {
                                $resultRequest = ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($myUserID), intval($userIDRececer)), htmlspecialchars($entry), $myUserID);
                            } else if(ControllerUser::isPro(intval($myUserID))) {
                                $resultRequest = ControllerChatProUser::newMessage(ControllerChatProUser::openChat(intval($userIDRececer), intval($myUserID)), htmlspecialchars($entry), $myUserID);
                            }
                        // }
                    }
                // }
            }
          echo json_encode($resultRequest);
        }
    }