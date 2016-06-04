<?php

namespace Trinity\NotificationBundle\Exception;

use Trinity\MessagesBundle\Message\Message;

/**
 * Class MessageNotProcessedException
 * @package Trinity\NotificationBundle\Exception
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

