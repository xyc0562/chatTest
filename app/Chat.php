<?php
namespace App;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Illuminate\Encryption\Encrypter;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $cache;
    protected $crypt;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->cache = new \Memcached();
        $this->cache->addServer('localhost', 11211);
        $this->crypt = new Encrypter('hkldgshkjds88952');
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
/*        $cryptSessionId = $conn->WebSocket->request->getCookies()['laravel_session'];
        $sessionId = $this->crypt->decrypt($cryptSessionId);
        $session = \unserialize($this->cache->get('laravel:'.$sessionId));*/

        $conn->send('Hello ');
    }

    public function onMessage(ConnectionInterface $from, $msg) {
/*        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // The sender is not the receiver, send to each client connected
                $client->send($msg);
            }
        }*/
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

    public function sendMsgToQueue($msg) {
        foreach ($this->clients as $client) {
            $client->send($msg);
        }
    }
}
