<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class ReadMessageEvent
 *
 * Is dispatched when the message is successfully unpacked and ready to be read by user of this bundle.
 */
class ReadMessageEvent extends MessageEvent
{
    const NAME = 'trinity.messages.readMessage';

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

    /**
     * @return string
     */
    public function getMessageJson(): string
    {
        return $this->messageJson;
    }

    /**
     * @param string $messageJson
     */
    public function setMessageJson(string $messageJson)
    {
        $this->messageJson = $messageJson;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     */
    public function setSource(string $source)
    {
        $this->source = $source;
    }

    /**
     * @return bool
     */
    public function isEventProcessed(): bool
    {
        return $this->eventProcessed;
    }

    /**
     * @param bool $eventProcessed
     */
    public function setEventProcessed(bool $eventProcessed)
    {
        $this->eventProcessed = $eventProcessed;
    }
}
