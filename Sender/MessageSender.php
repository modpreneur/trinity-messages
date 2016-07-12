<?php

namespace Trinity\Bundle\MessagesBundle\Sender;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Trinity\Bundle\MessagesBundle\Event\SendMessageEvent;
use Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException;
use Trinity\Bundle\MessagesBundle\Exception\MissingSendMessageListenerException;
use Trinity\Bundle\MessagesBundle\Interfaces\MessageUserProviderInterface;
use Trinity\Bundle\MessagesBundle\Interfaces\SecretKeyProviderInterface;
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

    /** @var  MessageUserProviderInterface */
    protected $messageUserProvider;

    /** @var  SecretKeyProviderInterface */
    protected $secretKeyProvider;

    /**
     * MessageSender constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     * @param string                   $senderIdentification
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        string $senderIdentification
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->senderIdentification = $senderIdentification;
    }

    /**
     * Send all messages.
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSendMessageListenerException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageTypeException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageUserException
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
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageUserException
     */
    public function sendMessage(Message $message)
    {
        if ($this->eventDispatcher->hasListeners(SendMessageEvent::NAME) === false) {
            throw new MissingSendMessageListenerException(
                'There is no listener for event ' . SendMessageEvent::NAME . ' so nobody is able to send the message'
            );
        }

        if ($message->getSender() === '') {
            $message->setSender($this->senderIdentification);
        }

        if ($message->getUser() === '') {
            $message->setUser($this->messageUserProvider->getUser($message));
        }

        if ($message->getSecretKey() === '') {
            $message->setSecretKey($this->secretKeyProvider->getSecretKey($message->getClientId()));
        }

        $event = new SendMessageEvent($message);

        /** @var SendMessageEvent $event */
        $this->eventDispatcher->dispatch(SendMessageEvent::NAME, $event);
    }

    /**
     * @return MessageUserProviderInterface
     */
    public function getMessageUserProviderInterface()
    {
        return $this->messageUserProvider;
    }

    /**
     * @param MessageUserProviderInterface $messageUserProvider
     */
    public function setMessageUserProvider(MessageUserProviderInterface $messageUserProvider)
    {
        $this->messageUserProvider = $messageUserProvider;
    }

    /**
     * @return SecretKeyProviderInterface
     */
    public function getSecretKeyProvider()
    {
        return $this->secretKeyProvider;
    }

    /**
     * @param SecretKeyProviderInterface $secretKeyProvider
     */
    public function setSecretKeyProvider($secretKeyProvider)
    {
        $this->secretKeyProvider = $secretKeyProvider;
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
