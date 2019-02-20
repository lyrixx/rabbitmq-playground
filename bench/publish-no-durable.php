<?php

$connection = new AMQPConnection(array(
    'vhost' => 'bench',
    'host' => 'rabbitmq-3.lxd'
));
$connection->connect();
$channel = new AMQPChannel($connection);

$exchange = new AMQPExchange($channel);
$exchange->setName('direct_no_durable');
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->declareExchange();

$queue = new \AMQPQueue($channel);
$queue->setName('direct_no_durable');
$queue->declareQueue();
$queue->bind('direct_no_durable');

while (true) {
    $exchange->publish('.');
}
