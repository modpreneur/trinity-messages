<?php

namespace Trinity\Bundle\MessagesBundle\EventListener;

use Trinity\Bundle\MessagesBundle\Event\UnpackMessageEvent;
use Trinity\Bundle\MessagesBundle\Reader\MessageReader;

/**
 * Class MessageListener
 * @package Trinity\Bundle\MessagesBundle\EventListener
 */
class MessageListener
{
    /** @var  MessageReader */
    protected $messageReader;

    /**
     * MessageListener constructor.
     *
     * @param MessageReader $messageReader
     */
    public function __construct(MessageReader $messageReader)
    {
        $this->messageReader = $messageReader;
    }

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