<?php

`rabbitmqadmin --vhost /queue-type delete exchange name=foo 2>&1 > /dev/null`;
`rabbitmqadmin --vhost /queue-type delete queue name=bar 2>&1 > /dev/null`;
`rabbitmqadmin --vhost /queue-type delete queue name=baz 2>&1 > /dev/null`;
`rabbitmqadmin --vhost /queue-type delete queue name=bazinga 2>&1 > /dev/null`;

require __DIR__.'/Broker.php';

$conn = new AMQPConnection(array(
    'vhost' => '/queue-type',
));

$broker = new Broker($conn);
$broker->connect();

function create_exchange(Broker $broker, $type = \AMQP_EX_TYPE_DIRECT)
{
    echo "* An Exchange \"foo\"\n";

    return $broker->createExchange('foo', $type);
}

function create_queues(Broker $broker, array $queues)
{
    foreach ($queues as $name => $routingKeys) {
        $queues[$name] = create_queue($broker, $name, $routingKeys);
    }

    return $queues;
}

function create_queue(Broker $broker, $name, $routingKeys)
{
    $routingKeys = (array) $routingKeys;

    echo sprintf('* A queue "%s", bound to exchange "foo" with routing key "%s"%s', $name, implode('", "', $routingKeys), PHP_EOL);
    $queue = $broker->createQueue($name);
    foreach ($routingKeys as $routingKey) {
        $queue->bind('foo', $routingKey);
    }

    return $queue;
}

function publish_and_consume(AmqpExchange $exchange, $routingKey, array $queues, $message = 'A message.')
{
    echo sprintf('If I publish "%s" to exchange "foo", with routing key "%s":%s', $message, $routingKey, PHP_EOL);
    $exchange->publish($message, $routingKey);
    usleep(100);
    consume($queues);
    echo "\n";
};

function consume(array $queues)
{
    foreach ($queues as $name => $queue) {
        echo sprintf('  queue: "%s":%s', $name, PHP_EOL);
        while (false !== $msg = $queue->get()) {
            echo sprintf('      msg: "%s", routing-key: "%s", id: "%d"%s', $msg->getBody(), $msg->getRoutingKey(), $msg->getDeliveryTag(), PHP_EOL);
            $queue->ack($msg->getDeliveryTag());
        }
    }
}

return $broker;
