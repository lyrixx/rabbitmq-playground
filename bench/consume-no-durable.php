<?php

$connection = new AMQPConnection(array(
    'vhost' => 'bench',
    'host' => 'rabbitmq-3.lxd'
));
$connection->connect();
$channel = new AMQPChannel($connection);

$queue = new \AMQPQueue($channel);
$queue->setName('direct_no_durable');
$queue->declareQueue();
$queue->bind('direct_no_durable');

function consume() {

}

while (true) {
    $queue->consume('consume', AMQP_AUTOACK);
}
