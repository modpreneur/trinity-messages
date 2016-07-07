<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class BeforeMessagePublishEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * This event is not dispatched anywhere but it can be used by lower level class.
 */
class BeforeMessagePublishEvent extends Event
{
    /** @var  Message */
    protected $message;

    /**
     * BeforeMessagePublish constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage() : Message
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }
}
