<?php

//the difference between topic and direct is the wildcard % #

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

//在sender里面就要建Exchange->topic
$channel->exchange_declare('goods-topic', 'topic', false, false, false);

$data = "Goods be deleted, id = 001";

$msg = new AMQPMessage($data);

//the routingKey is 'item.delete'
// $channel->basic_publish($msg, 'goods-topic', 'item.delete');
//可以自己测试，这个worker1就收不到，worker2可以收到
$channel->basic_publish($msg, 'goods-topic', 'item.insert');

// var_dump($msg);

echo $data;

$channel->close();
$connection->close();
