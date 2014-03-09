<?php

$broker = require __DIR__.'/bootstrap.php';

$exchange = create_exchange($broker, \AMQP_EX_TYPE_DIRECT);

$queues = create_queues($broker, array(
    'bar' => 'bar-routing-key',
    'baz' => 'baz-routing-key',
    'bazinga' => array('bar-routing-key', 'baz-routing-key'),
));

echo "\n";

publish_and_consume($exchange, 'bar', $queues);
publish_and_consume($exchange, 'bar-routing-key', $queues);
publish_and_consume($exchange, 'baz', $queues);
publish_and_consume($exchange, 'baz-routing-key', $queues);
publish_and_consume($exchange, 'bazinga', $queues);
