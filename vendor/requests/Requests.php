<?php
namespace RequestsStream;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use \Controller\ControllerUser;
use Controller\ControllerChatProUser;
use Model\Config;
use \verification\MessageVerification;

include_once __DIR__ . '/../../controller/connection.php';
include_once __DIR__ . '/../../requests/newMessage.php';
include_once __DIR__ . '/../../controller/chatProUser.php';

class Requests implements MessageComponentInterface {
    protected $clients;
    private $allowedComands = ['SEND MESSAGE'];
    public function __construct() {
        $this->clients = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $uniqueSeed = Config::urlSafeEncode(random_bytes(8));

        $this->clients[$conn->resourceId] = [$conn, -1];

        // echo $this->clients[$conn->resourceId][1];
        // echo 
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $message) {
        // echo $message . PHP_EOL;
        $message = json_decode($message);

        # message = [[userID, ConnectionToken], action, [args]] 

        # action == SendMessage -> args = [userTo, Message]

        if(!count($message) === 3) return;

        if ($message[1] === "Connection" && $this->clients[$from->resourceId][1] === -1) {
            if (ControllerUser::userExisiting(htmlspecialchars($message[0][0])) && password_verify(ControllerUser::getHashFromUserID(htmlspecialchars($message[0][0])), htmlspecialchars($message[0][1]))) {
                    $this->clients[$from->resourceId][1] = $message[0][0];
                echo "UserID : " . $this->clients[$from->resourceId][1] . PHP_EOL;
            } else {
                return;
            }
        }

        if ($message[1] === "SendMessage" && $this->clients[$from->resourceId][1] !== -1) {
            $toID = ControllerChatProUser::getLastUser(intval($message[0][0]), intval(htmlspecialchars($message[2][0])));
            if (ControllerUser::userExisiting($toID)) {
                if(ControllerChatProUser::newMessage(htmlspecialchars($message[2][0]), $message[2][1],  $message[0][0]) === 0) {
                    $from->send(json_encode(['lastMessage', array('message_content' => htmlspecialchars($message[2][1]), 'isMe' => True)]));
                    // echo "nb de co : "  . count($this->clients) . PHP_EOL;
                    foreach ($this->clients as $user) {
                        if (intval($user[1]) === $toID) {
                            if ($user[0]->send(json_encode(['lastMessage', array('message_content' => htmlspecialchars($message[2][1]), 'isMe' => False)]))) {
                                // ça marche !!!!!!!!!!!!!!!!
                                // echo 'Working++' . PHP_EOL;
                            }
                            break;
                        }
                    }
                }
            } else {
                // user not existing
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        unset($this->clients[$conn->resourceId]);
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}