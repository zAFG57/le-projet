<?php 
    require_once('database.php');

    /**
     * undocumented class
     * 
     */
    
    class User extends database{

        private $userInfo;

        public function __construct($id) {
            self::getInfoUser($id);
        }

        protected static function getInfoUser($id) {
            if (!$id) return;

            $res = parent::sqlSelect('SELECT 
                users.id, users.username, users.email, users.verified, users.pro
                FROM users 
                WHERE users.id = ?',
                'i', $id);

                if ($res && $res->num_rows === 1) {
                    $this->userInfo = $res->fetch_assoc();
                }  

                if ($this->isPro()) {
                    $ress = parent::sqlSelect('SELECT 
                    ville, objets_reparables, note
                    FROM pro_users WHERE pro_users.user_id = ?',
                    'i', $id);

                    if ($ress && $ress->num_rows === 1) {
                        $this->userInfo += $ress->fetch_assoc();
                    } 
                }
        }

        protected static function isPro($id){
            return $this->parent::sqlSelect('SELECT users.pro FROM users WHERE users.id = ?', 'i', $id)->fetch_assoc()['pro'];
        }

        protected static function isConnected() {
            return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) && $_SESSION['userID'] > 0;
        }

        protected static function isAdmin($id) {
            $res = parent::sqlSelect('SELECT admin_type FROM admin WHERE admin.user_id = ?', 'i', $id);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro) {
                    return $userPro['admin_type'] === 'super admin';  
                }
            }
            return false;
        }
    }
    