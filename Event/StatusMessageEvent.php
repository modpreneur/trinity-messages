<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Trinity\Bundle\MessagesBundle\Message\StatusMessage;

/**
 * Class StatusMessageEvent
 * @package Trinity\Bundle\MessagesBundle\Event
 */
class StatusMessageEvent extends Event
{
    /** @var  StatusMessage */
    protected $statusMessage;


    /**
     * StatusMessageEvent constructor.
     *
     * @param StatusMessage $statusMessage
     */
    public function __construct(StatusMessage $statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }


    /**
     * @return StatusMessage
     */
    public function getStatusMessage() : StatusMessage
    {
        return $this->statusMessage;
    }


    /**
     * @param StatusMessage $statusMessage
     */
    public function setStatusMessage(StatusMessage $statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }
}
