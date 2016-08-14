<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class BeforeMessagePublishEvent
 *
 * This event is not dispatched anywhere but it can be used by lower level class.
 */
class BeforeMessagePublishEvent extends MessageEvent
{
    const NAME = 'trinity.messages.beforeMessagePublish';

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
