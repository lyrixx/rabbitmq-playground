<?php

require __DIR__.'/Broker.php';

$conn = new AMQPConnection(array(
    'vhost' => '/debug-req-resp',
));

$broker = new Broker($conn);
$broker->connect();

return $broker;
