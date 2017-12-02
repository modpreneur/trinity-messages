<?php

namespace Trinity\Bundle\MessagesBundle\Sender;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Trinity\Bundle\MessagesBundle\Event\SendMessageEvent;
use Trinity\Bundle\MessagesBundle\Exception\MissingSendMessageListenerException;
use Trinity\Bundle\MessagesBundle\Interfaces\MessageUserProviderInterface;
use Trinity\Bundle\MessagesBundle\Interfaces\SecretKeyProviderInterface;
use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Class MessageSender.
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
     * @throws MissingSendMessageListenerException
     */
    public function sendAll(): void
    {
        foreach ($this->messages as $message) {
            $this->sendMessage($message);
        }

        $this->clear();
    }

    /**
     * Send one message.
     *
     * @param Message $message
     *
     * @throws MissingSendMessageListenerException
     */
    public function sendMessage(Message $message): void
    {
        if ($this->eventDispatcher->hasListeners(SendMessageEvent::NAME) === false) {
            throw new MissingSendMessageListenerException(
                'There is no listener for event '.SendMessageEvent::NAME.' so nobody is able to send the message'
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

        /* @var SendMessageEvent $event */
        $this->eventDispatcher->dispatch(SendMessageEvent::NAME, $event);
    }

    /**
     * @return MessageUserProviderInterface
     */
    public function getMessageUserProviderInterface(): MessageUserProviderInterface
    {
        return $this->messageUserProvider;
    }

    /**
     * @param MessageUserProviderInterface $messageUserProvider
     */
    public function setMessageUserProvider(MessageUserProviderInterface $messageUserProvider): void
    {
        $this->messageUserProvider = $messageUserProvider;
    }

    /**
     * @return SecretKeyProviderInterface
     */
    public function getSecretKeyProvider(): SecretKeyProviderInterface
    {
        return $this->secretKeyProvider;
    }

    /**
     * @param SecretKeyProviderInterface $secretKeyProvider
     */
    public function setSecretKeyProvider($secretKeyProvider): void
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
    public function setMessages(array $messages): void
    {
        $this->messages = $messages;
    }

    /**
     * @param Message $message
     */
    public function addMessage(Message $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * Clear queued messages.
     */
    public function clear(): void
    {
        $this->messages = [];
    }
}
