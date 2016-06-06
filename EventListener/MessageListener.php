<?php

namespace Trinity\Bundle\MessagesBundle\EventListener;

use Trinity\Bundle\MessagesBundle\Event\UnpackMessageEvent;
use Trinity\Bundle\MessagesBundle\Message\MessageReader;

/**
 * Class MessageListener
 * @package Trinity\Bundle\MessagesBundle\EventListener
 */
class MessageListener
{
    /** @var  MessageReader */
    protected $messageReader;

    /**
     * @param UnpackMessageEvent $event
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\DataNotValidJsonException
     */
    public function onUnpackMessageEvent(UnpackMessageEvent $event)
    {
        $this->messageReader->read($event->getMessageJson(), $event->getSource());
    }
}