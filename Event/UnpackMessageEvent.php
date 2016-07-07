<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class UnpackMessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * This event is dispatched by the lower level class which is responsible for sending strings representing messages.
 * It is the entrypoint when reading a message.
 */
class UnpackMessageEvent extends Event
{
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
}
