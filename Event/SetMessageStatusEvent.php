<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class SetMessageStatusEvent.
 */
class SetMessageStatusEvent extends MessageEvent
{
    const NAME = 'trinity.messages.setMessageStatus';

    /** @var  Message */
    protected $message;

    /** @var  string */
    protected $statusMessage;

    /** @var  string */
    protected $status;

    /**
     * SetMessageStatusEvent constructor.
     *
     * @param Message $message
     * @param string  $statusMessage
     * @param string  $status
     */
    public function __construct(Message $message, string $status, string $statusMessage)
    {
        $this->message = $message;
        $this->statusMessage = $statusMessage;
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatusMessage() : string
    {
        return $this->statusMessage;
    }

    /**
     * @param string $statusMessage
     */
    public function setStatusMessage(string $statusMessage)
    {
        $this->statusMessage = $statusMessage;
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

    /**
     * @return string
     */
    public function getStatus() : string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
    }
}
