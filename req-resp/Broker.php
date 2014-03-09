<?php

class Broker
{
    protected $conn;
    protected $exchanges;
    protected $queues;
    protected $channel;
    protected $client;

    public function __construct(\AMQPConnection $conn)
    {
        $this->conn = $conn;
    }

    public function publishRequest($message, $responseQueueName, $correlationId)
    {
        $this->exchanges['request']->publish($message, 'request', \AMQP_MANDATORY, array(
            'delivery_mode' => 2,
            'reply_to' => $responseQueueName,
            'correlation_id' => $correlationId,
        ));
    }

    public function consumeRequest()
    {
        return $this->queues['request']->get();
    }

    public function ackRequest(\AMQPEnvelope $msg)
    {
        $this->queues['request']->ack($msg->getDeliveryTag());
    }

    private function getResponseQueue($responseQueueName)
    {
        if (!isset($this->queues[$responseQueueName])) {
            $this->queues[$responseQueueName] = $this->createQueue($responseQueueName);
            $this->queues[$responseQueueName]->bind('response', $responseQueueName);
        }

        return $this->queues[$responseQueueName];
    }

    public function publishResponse($message, $responseQueueName, $correlationId)
    {
        $this->exchanges['response']->publish($message, $responseQueueName, \AMQP_MANDATORY, array(
            'delivery_mode' => 2,
            'correlation_id' => $correlationId,
        ));
    }

    public function consumeResponse($responseQueueName)
    {
        return $this->getResponseQueue($responseQueueName)->get();
    }

    public function ackResponse(\AMQPEnvelope $msg)
    {
        $this->getResponseQueue($msg->getRoutingKey())->ack($msg->getDeliveryTag());
    }

    public function disconnect()
    {
        if ($this->conn->isConnected()) {
            $this->conn->disconnect();
        }
    }

    public function connect()
    {
        if ($this->conn->isConnected()) {
            return;
        }

        $this->conn->reconnect();
        $this->channel = new \AMQPChannel($this->conn);

        $this->exchanges['request'] = $this->createExchange('request');
        $this->queues['request'] = $this->createQueue('request');
        $this->queues['request']->bind('request', 'request');

        $this->exchanges['response'] = $this->createExchange('response');
    }

    protected function createExchange($name)
    {
        $exchange = new \AMQPExchange($this->channel);
        $exchange->setName($name);
        $exchange->setType(\AMQP_EX_TYPE_DIRECT);
        $exchange->setFlags(\AMQP_DURABLE);
        $exchange->declareExchange();

        return $exchange;
    }

    protected function createQueue($name)
    {
        $queue = new \AMQPQueue($this->channel);
        $queue->setName($name);
        $queue->setFlags(\AMQP_DURABLE);
        $queue->declareQueue();

        return $queue;
    }
}
