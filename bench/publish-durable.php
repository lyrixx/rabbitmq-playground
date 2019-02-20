<?php

$connection = new AMQPConnection(array(
    'vhost' => 'bench',
    'host' => 'rabbitmq-3.lxd'
));
$connection->connect();
$channel = new AMQPChannel($connection);

$exchange = new AMQPExchange($channel);
$exchange->setName('direct_durable');
$exchange->setType(AMQP_EX_TYPE_DIRECT);
$exchange->setFlags(\AMQP_DURABLE);
$exchange->declareExchange();

$queue = new \AMQPQueue($channel);
$queue->setName('direct_durable');
$queue->setFlags(\AMQP_DURABLE);
$queue->declareQueue();
$queue->bind('direct_durable');

while (true) {
    $exchange->publish('.');
}
