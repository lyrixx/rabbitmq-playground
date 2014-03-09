<?php

class Broker
{
    private $exchanges;
    private $queues;
    private $conn;
    private $channel;

    public function __construct(\AMQPConnection $conn)
    {
        $this->conn = $conn;
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
    }

    public function createExchange($name, $type = \AMQP_EX_TYPE_DIRECT)
    {
        $exchange = new \AMQPExchange($this->channel);
        $exchange->setName($name);
        $exchange->setType($type);
        $exchange->setFlags(\AMQP_DURABLE);
        $exchange->declareExchange();

        return $exchange;
    }

    public function createQueue($name)
    {
        $queue = new \AMQPQueue($this->channel);
        $queue->setName($name);
        $queue->setFlags(\AMQP_DURABLE);
        $queue->declareQueue();

        return $queue;
    }
}
