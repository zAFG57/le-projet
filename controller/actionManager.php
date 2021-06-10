<?php 
    namespace Controller;

    use \Model\ActionManager;

    include_once __DIR__ . '/../model/actionManager.php';

    /**
     * @author Jules GRIVOT PELISSON
     * 
     * @todo create the functions
     * @version 0.1
     * @copyright
     */

    class ControllerActionManager extends ActionManager{
        /**
         * @author Jules GRIVOT PELISSON 
         * 
         * @return boolean if the token in params is allowable
         * 
         * @version 0.1
         * @copyright
         */
        public static function allowRequestAction($actionToken, $schema){
            return ActionManager::allowRequestAction(htmlspecialchars($actionToken), $schema);
        }

        public static function createRequestAction($schema){
            return ActionManager::createRequestAction($schema);
        }   
    }
    