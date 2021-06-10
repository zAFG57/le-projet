<?php 
    class Lang {
        public static function changeLang($lang) {
             $_SESSION['l'] = $lang;
        }
    }