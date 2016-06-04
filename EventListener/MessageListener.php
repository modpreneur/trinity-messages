<?php

namespace Trinity\MessagesBundle\EventListener;

use Trinity\MessagesBundle\Event\UnpackMessageEvent;
use Trinity\MessagesBundle\Message\MessageReader;

/**
 * Class MessageListener
 * @package Trinity\MessagesBundle\EventListener
 */
class MessageListener
{
    /** @var  MessageReader */
    protected $messageReader;

    /**
     * @param UnpackMessageEvent $event
     *
     * @throws \Trinity\MessagesBundle\Exception\DataNotValidJsonException
     */
    public function onUnpackMessageEvent(UnpackMessageEvent $event)
    {
        $this->messageReader->read($event->getMessageJson(), $event->getSource());
    }
}