<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class ReadMessageError
 * @package Trinity\Bundle\MessagesBundle\Event
 *
 * This event is dispatched when reading of a message failed.
 * This can by because of malformed data, missing credentials of invalid message format.
 */
class ReadMessageErrorEvent extends Event
{
    /** @var  string */
    protected $messageJson;

    /** @var  string */
    protected $source;

    /** @var  \Exception */
    protected $exception;

    /** @var  Message */
    protected $message;

    /**
     * ReadMessageError constructor.
     *
     * @param string     $messageJson
     * @param string     $source
     * @param \Exception $exception
     * @param Message    $message
     */
    public function __construct(string $messageJson, string $source, \Exception $exception, Message $message = null)
    {
        $this->messageJson = $messageJson;
        $this->source = $source;
        $this->exception = $exception;
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
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     */
    public function setException($exception)
    {
        $this->exception = $exception;
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
