<?php

//the difference between fanout and direct is the routingKey

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

//在sender里面就要建Exchange->direct
$channel->exchange_declare('goods', 'direct', false, false, false);

$data = "Goods be deleted, id = 001";

$msg = new AMQPMessage($data);

//the routingKey is 'delete'
$channel->basic_publish($msg, 'goods', 'delete');

// var_dump($msg);

echo $data;

$channel->close();
$connection->close();