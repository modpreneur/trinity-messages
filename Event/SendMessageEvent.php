<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class SendMessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * It could have one property of class Message but...
 * This event is meant to be listened by low level class which should not know(or can not know) about the Message object
 */
class SendMessageEvent extends Event
{
    /** @var string */
    protected $message;

    /** @var  string */
    protected $destination;

    /** @var  string */
    protected $source;

    /**
     * SendMessageEvent constructor.
     *
     * @param string $message
     * @param string $destination
     * @param string $source
     */
    public function __construct(string $message, string $destination, string $source)
    {
        $this->message = $message;
        $this->destination = $destination;
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination($destination)
    {
        $this->destination = $destination;
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