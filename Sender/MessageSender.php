<?php

namespace Trinity\Bundle\MessagesBundle\Sender;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Trinity\Bundle\MessagesBundle\Event\Events;
use Trinity\Bundle\MessagesBundle\Event\SendMessageEvent;
use Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException;
use Trinity\Bundle\MessagesBundle\Exception\MissingSendMessageListenerException;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class MessageSender
 *
 * @package Trinity\Bundle\MessagesBundle\Notification
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
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSendMessageListenerException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageTypeException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException
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
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageTypeException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     */
    public function sendMessage(Message $message)
    {
        if ($message->getSender() === null) {
            $message->setSender($this->senderIdentification);
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
