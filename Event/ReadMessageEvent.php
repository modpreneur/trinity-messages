<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class ReadMessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * Is dispatched when the message is successfully unpacked and ready to be read by user of this package.
 */
class ReadMessageEvent extends Event
{
    /** @var  Message */
    protected $message;

    /** @var  string */
    protected $messageJson;

    /** @var  string */
    protected $source;

    /** @var bool Was the event processed by any listener? */
    protected $eventProcessed = false;

    /**
     * ReadMessageEvent constructor.
     *
     * @param Message $message
     * @param string  $messageJson
     * @param string  $source
     */
    public function __construct(Message $message, string $messageJson, string $source)
    {
        $this->message = $message;
        $this->messageJson = $messageJson;
        $this->source = $source;
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

    /**
     * @return string
     */
    public function getMessageJson()
    {
        return $this->messageJson;
    }

    /**
     * @param string $messageJson
     */
    public function setMessageJson($messageJson)
    {
        $this->messageJson = $messageJson;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource($source)
    {
        $this->source = $source;
    }

    /**
     * @return boolean
     */
    public function isEventProcessed()
    {
        return $this->eventProcessed;
    }

    /**
     * @param boolean $eventProcessed
     */
    public function setEventProcessed($eventProcessed)
    {
        $this->eventProcessed = $eventProcessed;
    }
}
