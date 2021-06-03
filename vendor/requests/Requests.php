<?php
namespace RequestsStream;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use \Controller\ControllerConnection;
use Model\Config;
use \verification\MessageVerification;

include_once __DIR__ . '/../../controller/connection.php';
include_once __DIR__ . '/../../requests/newMessage.php'; 

class Requests implements MessageComponentInterface {
    protected $clients;
    private $allowedComands = ['SEND MESSAGE'];
    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $uniqueSeed = Config::urlSafeEncode(random_bytes(8));
        // echo $uniqueSeed . PHP_EOL;

        $this->clients->attach($conn, []);
        // echo $this->clients[$conn][1];
        $this->clients[$conn][0]->send(json_encode(['CONNECTION_TOKEN', $this->clients[$conn][2]]));
        // session_start();
        // echo $this->clients[$conn][0]->Session();
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $message) {
        echo $message;
        $message = json_decode($message);
        echo $message;
        echo $this->clients[$from][1] . PHP_EOL;
        echo $message[0] . PHP_EOL;

        if (!ControllerConnection::validateConnectionToken($message[0], $this->clients[$from][1])){
            echo 'not working' . PHP_EOL;
            return;
        }
        
        

        foreach ($this->allowedComands as $cmd) {
            // if ($cmd === $message[1]) {
                echo 'test';


                if ($message[1] === 'LOGIN') {
                    $uniqueSeed = Config::urlSafeEncode(random_bytes(8));
                    $connectionHashToken = $message[2];
                    $this->clients->attach($from, [$from, $uniqueSeed, ControllerConnection::createConnectionToken($uniqueSeed, $connectionHashToken)]);
                } else if ($message[1] === 'SEND MESSAGE') {
                    messageVerification::MessageVerification($message[2][0],$message[2][1], $message[2][2]);
                    // $client->send(json_encode('working'));
                } else if ($message[1] === "") {

                }
                // echo $this->clients[$from][0]->Session()->get('userID');
                break;
            // }
        }
        // $msg = json_decode($msg);
        // $numRecv = count($this->clients) - 1;
        // $this->clients->setInfo($message);
        // echo sprintf($this->clients->serialize() . "\n");
        // echo var_dump($from . "\n");
        // echo sprintf(gettype($message) . "\n");
        echo $message[1];
        // echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
        //     , $from->resourceId, $message, $numRecv, $numRecv > 1 ? '' : 's');

        foreach ($this->clients as $client) {
            // if ($from !== $client) {
                // The sender is not the receiver, send to each client connected

                // echo 'test';
                $client->send(json_encode('working'));
                // $client->send($msg);
            // }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}