<?php

namespace Trinity\Bundle\MessagesBundle\Interfaces;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Interface MessageUserProviderInterface.
 */
interface MessageUserProviderInterface
{
    /**
     * Get user identification which sent the message.
     *
     * @param Message $message
     *
     * @return string
     */
    public function getUser(Message $message) : string;
}
