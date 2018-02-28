<?php

require __DIR__.'/Broker.php';

$conn = new AMQPConnection(array(
    'vhost' => 'debug_req_resp',
    'host' => 'rabbitmq.lxc',
));

$broker = new Broker($conn);
$broker->connect();

return $broker;
