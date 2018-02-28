<?php

$broker = require __DIR__.'/bootstrap.php';

$exchange = create_exchange($broker, \AMQP_EX_TYPE_DIRECT);

while (true) {
    $exchange->publish('coucou', $argv[1] ?? 'manual');
}
