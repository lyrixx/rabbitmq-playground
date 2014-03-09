Vocabulary
==========

You **publish** a **message** to an **exchange**.
The **exchange** **routes** the message to **queue**.
A **consumer** **consumes** a **message** from a **queue**.

Facts
=====

* A queue is `bound` to an exchange and has a `routing-key`.
* If their is no queues bound to the exchange, the message is dropped.
* Exchanges can be durable or transient.
* There are 3 strategies for the routing / exchange (`direct`, `fanout`, `topic`).

Strategies
==========

Fanout
------

Their are:

* An Exchange `foo`;
* A queue `bar`, bound to exchange `foo` with routing key `bar-routing-key`;
* A queue `baz`, bound to exchange `foo` with routing key `baz-routing-key`;
* A queue `bazinga`, bound to exchange `foo` with routing keys `bar-routing-key`, `baz-routing-key`.

So:

* What happen if I publish a message to exchange `foo`, with routing key `bar`?
* What happen if I publish a message to exchange `foo`, with routing key `bar-routing-key`?
* What happen if I publish a message to exchange `foo`, with routing key `baz`?
* What happen if I publish a message to exchange `foo`, with routing key `baz-routing-key`?
* What happen if I publish a message to exchange `foo`, with routing key `bazinga`?

Summary:

**A fanout exchange routes messages to ALL of the queues that are bound to it.**

Direct
------

Their are:

* An Exchange `foo`;
* A queue `bar`, bound to exchange `foo` with routing key `bar-routing-key`;
* A queue `baz`, bound to exchange `foo` with routing key `baz-routing-key`;
* A queue `bazinga`, bound to exchange `foo` with routing keys `bar-routing-key`, `baz-routing-key`.

So:

* What happen if I publish a message to exchange `foo`, with routing key `bar`?
* What happen if I publish a message to exchange `foo`, with routing key `bar-routing-key`?
* What happen if I publish a message to exchange `foo`, with routing key `baz`?
* What happen if I publish a message to exchange `foo`, with routing key `baz-routing-key`?
* What happen if I publish a message to exchange `foo`, with routing key `bazinga`?

Summary:

**A direct exchange delivers messages to ALL of the queues based on the message routing key.**

> A queue binds to the exchange with a routing key K. When a new message with
routing key R arrives at the direct exchange, the exchange routes it to the
queue if K = R

Topic
-----

Their are:

* An Exchange `foo`;
* A queue `bar`, bound to exchange `foo` with routing key `bar`;
* A queue `baz`, bound to exchange `foo` with routing keys `*`.
* A queue `twitter`, bound to exchange `foo` with routing keys `twitter.*`.
* A queue `google`, bound to exchange `foo` with routing keys `#`.

So:

* What happen if I publish a message to exchange `foo`, with routing key `bar`?
* What happen if I publish a message to exchange `foo`, with routing key `foobar`?
* What happen if I publish a message to exchange `foo`, with routing key `twitter`?
* What happen if I publish a message to exchange `foo`, with routing key `twitter.sensiolabs`?
* What happen if I publish a message to exchange `foo`, with routing key `twitter.sensiolabs.like`?

Summary:

**Topic exchanges route messages to one or many queues based on matching between
a message routing key and the pattern that was used to bind a queue to an
exchange**
