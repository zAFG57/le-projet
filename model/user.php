<?php 
    /**
     * undocumented class
     * 
     */
    class User extends database{

        private $userInfo;

        public function __construct($id = false) {
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

        public function getInfoUser() {
            return $this->userInfo;
        }

        public function isPro(){
            return $this->userInfo['pro'];
        }

        public static function isConnected() {
            return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['userID']) && is_int($_SESSION['userID']) == 1 && $_SESSION['userID'] > 0;
        }

        public function isAdmin() {
            $res = parent::sqlSelect('SELECT admin_type FROM admin WHERE admin.id = ?', 'i', $this->userInfo['id']);

            if ($res->num_rows === 1) {
                $userPro = $res->fetch_assoc();
                
                if($userPro) {
                    return $userPro['admin_type'] === 'super admin';  
                }
            }
        }
    }
    