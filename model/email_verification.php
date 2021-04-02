<?php
    require_once('util.php');
    session_start();
function snedValidationEmail($email){ 
    $db = connect();
    if($db) {

        $oneDayAgo = time() - 60 * 60 * 24;
		$res = sqlSelect($db, 'SELECT users.id,users.username,users.verified,COUNT(requests.id) FROM users LEFT JOIN requests ON users.id = requests.username AND requests.type=0 AND requests.timestamp>? WHERE users.email=? GROUP BY users.id ', 'is', $oneDayAgo, $email);
        
        if ($res && $res->num_rows === 1) {
            $user = $res->fetch_assoc();
            if ($user['verified'] === 0) {
                if ($user['COUNT(requests.id)'] < MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY ) {
                    //validate request
                    $verifyCode = random_bytes(16);
                    $hash = password_hash($verifyCode, PASSWORD_DEFAULT);
                    
                    $requestID = sqlInsert($db, 'INSERT INTO requests VALUES (NULL, ?, ?, ?, 0)', 'isi', $user['id'], $hash, time());
                    
                    if ($requestID !== -1) {
                        if(sendEmail($email, $user['username'], 'Email Verification', '<a href="http://localhost/site/view/email_verification?id=' . $requestID . '&hash=' .urlSafeEncode($verifyCode) . '">cliquez sur ce lien pour vérifier votre email</a>')) {
                            return 0;
                        } else {
                            return 1;
                        }
                    } else {
                        return 2;
                       
                    }
                } else {
                    return 3;
                }
            } else {
                return 4;
            }
        } else {
            return 5;
        }
        
        $db->close();
    } else {
        return 6;
    }
    return -1;
}

if (isset($_POST['validateEmail']) && isset($_POST['csrf_token']) && validateToken($_POST['csrf_token'])) {
    echo snedValidationEmail($_POST['validateEmail']);
}