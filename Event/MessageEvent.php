<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class MessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 */
abstract class MessageEvent extends Event
{
    const NAME = 'trinity.messages.base_event';
}
