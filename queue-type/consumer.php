<?php

$broker = require __DIR__.'/bootstrap.php';

$queueName = $argv[1] ?? 'manual';

$exchange = create_exchange($broker, \AMQP_EX_TYPE_DIRECT);
$queue = create_queue($broker, $queueName, $queueName);

while (true) {
    while (false !== $message = $queue->get()) {
        dump([date('h:i:s') => $message->getBody()]);


        $queue->ack($message->getDeliveryTag());
    }

    usleep(100000);
}
