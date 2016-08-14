<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class MessageEvent.
 */
abstract class MessageEvent extends Event
{
    const NAME = 'trinity.messages.base_event';
}
