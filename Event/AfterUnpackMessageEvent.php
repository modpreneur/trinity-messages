<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class AfterMessageUnpackedEvent
 *
 * This event id dispatched when the message was unpacked either with or without error.
 * This event is meant to be used for logging all received message.
 */
class AfterUnpackMessageEvent extends MessageEvent
{
    const NAME = 'trinity.messages.afterUnpackMessage';

    /** @var  Message */
    protected $messageObject;

    /** @var  string */
    protected $messageJson = '';

    /** @var  \Exception */
    protected $exception;

    /** @var  string */
    protected $source;

    /**
     * AfterMessageUnpackedEvent constructor.
     *
     * @param Message    $messageObject
     * @param string     $messageJson
     * @param \Exception $exception
     * @param string     $source
     */
    public function __construct(
        string $messageJson,
        string $source,
        Message $messageObject = null,
        \Exception $exception = null
    ) {
        $this->messageJson = $messageJson;
        $this->source = $source;
        $this->messageObject = $messageObject;
        $this->exception = $exception;
    }

    /**
     * @return Message
     */
    public function getMessageObject()
    {
        return $this->messageObject;
    }

    /**
     * @param Message $messageObject
     */
    public function setMessageObject(Message $messageObject)
    {
        $this->messageObject = $messageObject;
    }

    /**
     * @return string
     */
    public function getMessageJson() : string
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
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return string
     */
    public function getSource() : string
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
}
