<?php

//same as one-one-sender

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

//true: make it durable 
$channel->queue_declare('multi', false, false, false, false);


for ($i = 0; $i < 10; $i++) {
    $data = "I'/m sending " . $i;
    $msg = new AMQPMessage($data);
    $channel->basic_publish($msg, '', 'multi');
    echo " [x] Sent all!\n";
};


$channel->close();
$connection->close();