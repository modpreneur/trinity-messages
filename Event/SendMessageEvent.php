<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class SendMessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * This event is used to listened by lower level class which is responsible for sending messages.
 */
class SendMessageEvent extends Event
{
    /** @var Message */
    protected $message;

    /**
     * SendMessageEvent constructor.
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
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
