<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

//这个地方卡很久，一定要提前定义这个常量
define($queue_name, '1-queue_name');

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();
//两边都要有exchange->topic
$channel->exchange_declare('goods-topic', 'topic', false, false, false);

$channel->queue_declare($queue_name, false, false, true, false);

//绑定routingKey—>item.delete   可以绑定多个
$channel->queue_bind($queue_name, 'goods-topic', 'item.delete');
$channel->queue_bind($queue_name, 'goods-topic', 'item.update');

echo " [*] Waiting\n";

$callback = function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

// $channel->close();
// $connection->close();