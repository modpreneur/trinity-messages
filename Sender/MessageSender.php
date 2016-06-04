<?php

namespace Trinity\MessagesBundle\Message;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Trinity\MessagesBundle\Event\Events;
use Trinity\MessagesBundle\Event\SendMessageEvent;
use Trinity\MessagesBundle\Exception\MissingMessageDestinationException;
use Trinity\NotificationBundle\Exception\MissingSendMessageListenerException;

/**
 * Class MessageSender
 *
 * @package Trinity\MessagesBundle\Notification
 */
class MessageSender
{
    /** @var Message[] */
    protected $messages = [];

    /** @var  EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var  string */
    protected $senderIdentification;

    /**
     * MessageSender constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $senderIdentification
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, string $senderIdentification)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->senderIdentification = $senderIdentification;
    }

    /**
     * Send all messages.
     *
     * @throws \Trinity\NotificationBundle\Exception\MissingSendMessageListenerException
     * @throws \Trinity\MessagesBundle\Exception\MissingMessageTypeException
     * @throws \Trinity\MessagesBundle\Exception\MissingMessageDestinationException
     */
    public function sendAll()
    {
        foreach ($this->messages as $message) {
            $this->sendMessage($message);
        }

        $this->clear();
    }

    /**
     * Send one message
     *
     * @param Message $message
     *
     * @throws MissingMessageDestinationException
     * @throws MissingSendMessageListenerException
     * @throws \Trinity\MessagesBundle\Exception\MissingMessageTypeException
     * @throws \Trinity\MessagesBundle\Exception\MissingClientIdException
     * @throws \Trinity\MessagesBundle\Exception\MissingSecretKeyException
     */
    public function sendMessage(Message $message)
    {
        if ($message->getSender() === null) {
            $message->setSender($this->senderIdentification);
        }

        if ($message->getDestination() === null) {
            throw new MissingMessageDestinationException('Message does not have destination');
        }

        if ($this->eventDispatcher->hasListeners(Events::SEND_MESSAGE) === false) {
            throw new MissingSendMessageListenerException(
                'There is no listener for event ' . Events::SEND_MESSAGE . ' so nobody is able to send the message'
            );
        }

        $event = new SendMessageEvent(
            $message->pack(),
            $message->getDestination(),
            $message->getSender()
        );

        /** @var SendMessageEvent $event */
        $this->eventDispatcher->dispatch(Events::SEND_MESSAGE, $event);
    }

    /**
     * @return Message[]
     */
    public function getMessages() : array
    {
        return $this->messages;
    }

    /**
     * @param Message[] $messages
     */
    public function setMessages(array $messages)
    {
        $this->messages = $messages;
    }

    /**
     * @param Message $message
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }

    /**
     * Clear queued messages
     */
    public function clear()
    {
        $this->messages = [];
    }
}
