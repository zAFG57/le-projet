<?php
    use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../src/PHPMailer-master/src/Exception.php';
	require '../src/PHPMailer-master/src/PHPMailer.php';
	require '../src/PHPMailer-master/src/SMTP.php';
    
class EmailVerification extends Database {
    protected static function userExisting($email) {
        return parent::sqlSelect('SELECT id FROM users WHERE email=?', 's', $email)->num_rows === 1;
    }

    protected static function isVerified($email){
        return parent::sqlSelect('SELECT verified FROM users WHERE email=?', 's', $email)->fetch_assoc()['verified'];
    }

    protected static function isMaxEmailVerificationAttemptsAchevied($email){
        return parent::sqlSelect('SELECT COUNT(requests.id) FROM users LEFT JOIN requests ON users.id = requests.userId AND requests.type=0 AND requests.timestamp>? WHERE users.email=? GROUP BY users.id ', 'is', time() - 60 * 60 * 24, $email)->fetch_assoc()['COUNT(requests.id)'] >= parent::$MAX_EMAIL_VERIFICATION_REQUESTS_PER_DAY;
    }

    protected static function saveHash($id, $hash){
        return parent::sqlInsert('INSERT INTO requests VALUES (NULL, ?, ?, ?, 0)', 'isi', $id, $hash, time());
    }

    protected static function getId($email) {
        return parent::sqlSelect('SELECT id FROM users WHERE email=?','s', $email)->fetch_assoc()['id'];
    }

    protected static function createHashCode($verifyCode){
        return password_hash($verifyCode, PASSWORD_DEFAULT);
    }

    protected static function getUsername($email) {
        return parent::sqlSelect('SELECT username FROM users WHERE email=?','s', $email)->fetch_assoc()['username'];
    }

    protected static function getEmail($id) {
        return parent::sqlSelect('SELECT email FROM users WHERE id=?','i', $id)->fetch_assoc()['email'];
    }

    protected static function sendEmail($to, $toName, $subj, $msg){
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = parent::$SMTP_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = parent::$SMTP_USERNAME;
            $mail->Password   = parent::$SMTP_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = parent::$SMTP_PORT;
    
            //Recipients
            $mail->setFrom(parent::$SMTP_FROM, parent::$SMTP_FROM_NAME);
            $mail->addAddress($to, $toName);
            
            //Content
            $mail->isHTML(true);
            $mail->Subject = $subj;
            $mail->Body    = $msg;
            
            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
        
    }

    protected static function requestExisting($requestId){
        return parent::sqlSelect('SELECT userId FROM requests WHERE id=? AND type=0', 'i', $requestId)->num_rows === 1;
    }

    protected static function requestTimestampEcceded($requestId){
        return parent::sqlSelect('SELECT timestamp FROM requests WHERE id=? AND type=0', 'i', $requestId)->fetch_assoc()['timestamp'] < (time() - 60*60*24);
    }

    protected static function verifyHash($hash, $dbHash){
        return password_verify(Config::urlSafeDecode($hash), $dbHash);
    }

    protected static function getHash($requestId){
        return parent::sqlSelect('SELECT hash FROM requests WHERE id=? AND type=0', 'i', $requestId)->fetch_assoc()['hash'];
    }

    protected static function updateDbVerified($userId){
        return parent::sqlUpdate('UPDATE users SET verified=1 WHERE id=?', 'i', $userId);
    }

    protected static function deleteOldsRequests($userId){
        return parent::sqlUpdate('DELETE FROM requests WHERE userId=? and type=0', 'i', $userId);
    }

    protected static function getUserId($requestId){
        return parent::sqlSelect('SELECT userId FROM requests WHERE id=? and type=0', 'i', $requestId)->fetch_assoc()['userId'];
    }

}
