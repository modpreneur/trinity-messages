<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class ReadMessageError
 *
 * This event is dispatched when reading of a message failed.
 * This can by because of malformed data, missing credentials of invalid message format.
 */
class ReadMessageErrorEvent extends MessageEvent
{
    const NAME = 'trinity.messages.readMessageError';

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
     * @return \Exception
     */
    public function getException(): \Exception
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
     * @return Message|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message|null
     */
    public function setMessage(Message $message = null)
    {
        $this->message = $message;
    }
}
