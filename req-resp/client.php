<?php

$broker = require __DIR__.'/bootstrap.php';


$clientId = isset($argv[1]) ? $argv[1] : mt_rand(0, 10000);
$responseQueueName = 'response_'.$clientId;
$requestsReponses = [];

function publish_request(Broker $broker, $responseQueueName, &$requestsReponses)
{
    $correlationId = mt_rand();
    $requestsReponses[$correlationId] = $msg = date('H:i:s').'  '.mt_rand();
    $broker->publishRequest($msg, $responseQueueName, $correlationId);
}

while (true) {

    // Ask random request
    publish_request($broker, $responseQueueName, $requestsReponses);

    // Consumer response
    while (false !== $msg = $broker->consumeResponse($responseQueueName)) {
        // Not for use, or race condition
        if (!isset($requestsReponses[$msg->getCorrelationId()])) {
            $broker->ackResponse($msg);

            continue;
        }

        echo sprintf('Initial message: "%s". Response: "%s"%s', $requestsReponses[$msg->getCorrelationId()], $msg->getBody(), PHP_EOL);

        unset($requestsReponses[$msg->getCorrelationId()]);

        $broker->ackResponse($msg, $responseQueueName);
    }

    usleep(1000);
}
