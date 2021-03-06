<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class SendMessageEvent
 *
 * This event is used to listened by lower level class which is responsible for sending messages.
 */
class SendMessageEvent extends MessageEvent
{
    const NAME = 'trinity.messages.sendMessage';

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
    public function getMessage(): Message
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
