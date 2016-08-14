<?php

namespace Trinity\Bundle\MessagesBundle\Event;

use Trinity\Bundle\MessagesBundle\Message\StatusMessage;

/**
 * Class StatusMessageEvent.
 */
class StatusMessageEvent extends MessageEvent
{
    const NAME = 'trinity.messages.statusMessageEvent';

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
