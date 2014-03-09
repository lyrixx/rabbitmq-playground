<?php

$broker = require __DIR__.'/bootstrap.php';

while (true) {
    while (false !== $msg = $broker->consumeRequest()) {
        $reponse = sprintf('body: "%s", replyTo: "%s", correlationId: "%s"', $msg->getBody(), $msg->getReplyTo(), $msg->getCorrelationId());
        $broker->publishResponse($reponse, $msg->getReplyTo(), $msg->getCorrelationId());
        $broker->ackRequest($msg);
    }

    usleep(100);
}
