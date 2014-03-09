<?php

$broker = require __DIR__.'/bootstrap.php';

$exchange = create_exchange($broker, \AMQP_EX_TYPE_TOPIC);

$queues = create_queues($broker, array(
    'bar' => 'bar',
    'wildcard' => '*',
    'twitter' => 'twitter.*',
    'google' => '#',
));

echo "\n";

publish_and_consume($exchange, 'bar', $queues);
publish_and_consume($exchange, 'foobar', $queues);
publish_and_consume($exchange, 'twitter', $queues);
publish_and_consume($exchange, 'twitter.sensiolabs', $queues);
publish_and_consume($exchange, 'twitter.sensiolabs.like', $queues);
