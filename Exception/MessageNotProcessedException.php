<?php

namespace Trinity\Bundle\MessagesBundle\Exception;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class MessageNotProcessedException
 * @package Trinity\Bundle\MessagesBundle\Exception
 */
class MessageNotProcessedException extends \Exception
{
    /** @var  Message */
    protected $messageObject;

    /**
     * @return Message
     */
    public function getMessageObject() : Message
    {
        return $this->messageObject;
    }

    /**
     * @param Message $messageObject
     *
     * @return MessageNotProcessedException
     */
    public function setMessageObject(Message $messageObject)
    {
        $this->messageObject = $messageObject;
        return $this;
    }
}

