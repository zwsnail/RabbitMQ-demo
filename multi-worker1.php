<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('multi', false, false, false, false);

echo " [*] Worker1 is waiting for messages\n";
$channel->basic_qos(null, 1, null); // fair dispatch

$callback = function ($msg) {
    echo ' [x]  Worker1  who sleeps for 1s received ', $msg->body, "\n";
    sleep(1);;
    //消息确认
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
};
$channel->basic_consume('multi', '', false, false, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

// $channel->close();
// $connection->close();