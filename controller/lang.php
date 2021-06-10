<?php 
    include_once '../model/csrfConfig.php';
    include_once '../model/lang.php';
    class ControllerLang extends Lang {
        public static function changeLang($lang) {
            session_start(); 
            $_SESSION['l'] = $lang;
        }
    }
    if (isset($_POST['langinput'])) {
            ControllerLang::changeLang(htmlspecialchars($_POST['langinput']));
            echo ControllerLang::changeLang(htmlspecialchars($_POST['langinput']));;
        }else {
        
    }