Administation
=============

4 tools:

* [web ui](http://127.0.0.1:15672)
* rabbitmqadmin
* rabbitmqctl
* [rabbitmq simulator](https://github.com/RabbitMQSimulator/RabbitMQSimulator)

Web UI
------

Online demo

rabbitmqadmin
-------------

[CLI](http://127.0.0.1:15672/cli/) tool that leverages the
[API](http://127.0.0.1:15672/api/) of the web UI.

Start with awesomeness:

    rabbitmqadmin --bash-completion | sudo tee /etc/bash_completion.d/rabbitmq
    . /etc/bash_completion.d/rabbitmq

Useful commands:

    rabbitmqadmin declare vhost name=/foobar
    rabbitmqadmin declare permission vhost=/foobar user=guest configure=.* write=.* read=.*

    rabbitmqadmin --vhost=/foobar declare queue name=bar

    rabbitmqadmin --vhost=/foobar publish routing_key=bar payload=test
    sleep 1
    rabbitmqadmin --vhost=/foobar list queues name messages_ready messages_unacknowledged messages
    rabbitmqadmin --vhost=/foobar get queue="bar"
    rabbitmqadmin --vhost=/foobar purge queue name=bar
    sleep 1
    rabbitmqadmin --vhost=/foobar list queues name messages_ready messages_unacknowledged messages
    rabbitmqadmin --vhost=/foobar get queue="bar"

    rabbitmqadmin --vhost=/foobar delete queue name=bar

    rabbitmqadmin --vhost=/foobar declare exchange name=foo type=direct
    rabbitmqadmin --vhost=/foobar delete exchange name=foo

    rabbitmqadmin delete vhost name=/foobar

All commands:

    Usage
    =====
      rabbitmqadmin [options] subcommand

      where subcommand is one of:

    Display
    =======

      list users [<column>...]
      list vhosts [<column>...]
      list connections [<column>...]
      list exchanges [<column>...]
      list bindings [<column>...]
      list permissions [<column>...]
      list channels [<column>...]
      list parameters [<column>...]
      list queues [<column>...]
      list policies [<column>...]
      list nodes [<column>...]
      show overview [<column>...]

    Object Manipulation
    ===================

      declare queue name=... [node=... auto_delete=... durable=...]
      declare vhost name=...
      declare user name=... password=... tags=...
      declare exchange name=... type=... [auto_delete=... internal=... durable=...]
      declare policy name=... pattern=... definition=... [priority=...]
      declare parameter component=... name=... value=...
      declare permission vhost=... user=... configure=... write=... read=...
      declare binding source=... destination_type=... destination=... routing_key=...
      delete queue name=...
      delete vhost name=...
      delete user name=...
      delete exchange name=...
      delete policy name=...
      delete parameter component=... name=...
      delete permission vhost=... user=...
      delete binding source=... destination_type=... destination=... properties_key=...
      close connection name=...
      purge queue name=...

    Broker Definitions
    ==================

      export <file>
      import <file>

    Publishing and Consuming
    ========================

      publish routing_key=... [payload=... payload_encoding=... exchange=...]
      get queue=... [count=... requeue=... payload_file=... encoding=...]

      * If payload is not specified on publish, standard input is used

      * If payload_file is not specified on get, the payload will be shown on
        standard output along with the message metadata

      * If payload_file is specified on get, count must not be set


rabbitmqctl
-----------

**Low level administration.**

Useful commands:

    sudo rabbitmqctl add_vhost /foobar
    sudo rabbitmqctl set_permissions -p /foobar guest '.*' '.*' '.*'
    sudo rabbitmqctl delete_vhost /foobar
    watch -n 1 'sudo rabbitmqctl list_queues name messages_ready messages_unacknowledged messages'

All commands

    stop [<pid_file>]
    stop_app
    start_app
    wait <pid_file>
    reset
    force_reset
    rotate_logs <suffix>

    join_cluster <clusternode> [--ram]
    cluster_status
    change_cluster_node_type disc | ram
    forget_cluster_node [--offline]
    update_cluster_nodes clusternode
    sync_queue queue
    cancel_sync_queue queue

    add_user <username> <password>
    delete_user <username>
    change_password <username> <newpassword>
    clear_password <username>
    set_user_tags <username> <tag> ...
    list_users

    add_vhost <vhostpath>
    delete_vhost <vhostpath>
    list_vhosts [<vhostinfoitem> ...]
    set_permissions [-p <vhostpath>] <user> <conf> <write> <read>
    clear_permissions [-p <vhostpath>] <username>
    list_permissions [-p <vhostpath>]
    list_user_permissions <username>

    set_parameter [-p <vhostpath>] <component_name> <name> <value>
    clear_parameter [-p <vhostpath>] <component_name> <key>
    list_parameters [-p <vhostpath>]

    set_policy [-p <vhostpath>] [--priority <priority>] [--apply-to <apply-to>] <name> <pattern>  <definition>
    clear_policy [-p <vhostpath>] <name>
    list_policies [-p <vhostpath>]

    list_queues [-p <vhostpath>] [<queueinfoitem> ...]
    list_exchanges [-p <vhostpath>] [<exchangeinfoitem> ...]
    list_bindings [-p <vhostpath>] [<bindinginfoitem> ...]
    list_connections [<connectioninfoitem> ...]
    list_channels [<channelinfoitem> ...]
    list_consumers [-p <vhostpath>]
    status
    environment
    report
    eval <expr>

    close_connection <connectionpid> <explanation>
    trace_on [-p <vhost>]
    trace_off [-p <vhost>]
    set_vm_memory_high_watermark <fraction>

rabbitmq simulator
------------------

Online demo

