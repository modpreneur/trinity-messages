<?php

namespace Trinity\Bundle\MessagesBundle\Event;

/**
 * Class UnpackMessageEvent
 *
 * This event is dispatched by the lower level class which is responsible for sending strings representing messages.
 * It is the entrypoint when reading a message.
 */
class UnpackMessageEvent extends MessageEvent
{
    const NAME = 'trinity.messages.unpackMessage';

    /** @var  string */
    protected $messageJson;

    /** @var  string Place where was the message obtained(RabbitMQ queue, api endpoint, etc.) */
    protected $source;

    /**
     * MessageReadEvent constructor.
     *
     * @param string $messageJson
     * @param string $source
     */
    public function __construct(string $messageJson, string $source)
    {
        $this->messageJson = $messageJson;
        $this->source = $source;
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
}
