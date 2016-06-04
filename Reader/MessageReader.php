<?php

namespace Trinity\MessagesBundle\Message;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Trinity\MessagesBundle\Event\AfterUnpackMessageEvent;
use Trinity\MessagesBundle\Event\Events;
use Trinity\MessagesBundle\Event\ReadMessageError;
use Trinity\MessagesBundle\Event\ReadMessageEvent;
use Trinity\MessagesBundle\Interfaces\SecretKeyProviderInterface;
use Trinity\NotificationBundle\Exception\HashMismatchException;
use Trinity\NotificationBundle\Exception\MessageNotProcessedException;

/**
 * Class MessageReader
 *
 * This class is an starting point for incoming message.
 *
 * @package Trinity\MessagesBundle\Message
 */
class MessageReader
{
    /** @var  EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var SecretKeyProviderInterface */
    protected $secretKeyProvider;

    /** @var  bool Set strict mode in which the reader will require all messages to be handled by any listener */
    protected $requireMessageProcessing;

    /**
     * MessageReader constructor.
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $messageJson
     * @param string $source Source of the message(rabbit queue, API endpoint)
     *
     * @throws \Trinity\MessagesBundle\Exception\DataNotValidJsonException
     */
    public function read(string $messageJson, string $source)
    {
        $messageObject = null;

        try {
            // Try to unpack and dispatch error with message.
            // This allows to log all incoming messages even those which were not unpacked correctly
            $messageObject = $this->getAndDispatchMessageObject($messageJson, $source);
            $this->checkHash($messageObject);

            //now the $messageObject is successfully unpacked
            $event = new ReadMessageEvent($messageObject, $messageJson, $source);
            /** @var ReadMessageEvent $event */
            $event = $this->eventDispatcher->dispatch(Events::READ_MESSAGE, $event);
            $messageObject = $event->getMessage();

            if ($this->requireMessageProcessing === true) {
                $this->checkIfTheMessageWasProcessed($event, $messageObject);
            }
            //there is no dispatching of success event as that is responsibility of the user of this class
        } catch (\Exception $exception) {
            //but there is dispatching of error event - this errors are mostly due to unpacking message
            $this->dispatchErrorEvent($messageJson, $source, $exception, $messageObject);
        }
    }

    /**
     * @param string $messageString
     * @param string $source
     *
     * @return Message
     * @throws \Exception
     */
    protected function getAndDispatchMessageObject(string $messageString, string $source)
    {
        try {
            $messageObject = Message::unpack($messageString);
            $this->dispatchAfterMessageUnpackedEvent($messageString, $source, $messageObject);

            return $messageObject;
        } catch (\Exception $exception) {
            $this->dispatchAfterMessageUnpackedEvent($messageString, $source, null, $exception);

            throw $exception;
        }
    }

    /**
     * @param SecretKeyProviderInterface $secretKeyProvider
     */
    public function setClientSecretProvider(SecretKeyProviderInterface $secretKeyProvider)
    {
        $this->secretKeyProvider = $secretKeyProvider;
    }

    /**
     * Get client secret from the message.
     *
     * @param Message $message
     *
     * @return string
     */
    protected function getSecretKey(Message $message) : string
    {
        return $this->secretKeyProvider->getSecretKey($message->getClientId());
    }

    /**
     * Log message
     *
     * @param string       $messageJson
     * @param string       $source
     * @param Message|null $messageObject null when unpacking of the message failed
     * @param \Exception   $exception
     */
    protected function dispatchAfterMessageUnpackedEvent(
        string $messageJson,
        string $source,
        Message $messageObject = null,
        \Exception $exception = null
    ) {
        $event = new AfterUnpackMessageEvent($messageJson, $source, $messageObject, $exception);

        $this->eventDispatcher->dispatch(Events::AFTER_MESSAGE_UNPACKED, $event);
    }

    /**
     * @param Message $messageObject
     *
     * @throws \Trinity\NotificationBundle\Exception\HashMismatchException
     * @throws \Trinity\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\MessagesBundle\Exception\MissingClientIdException
     */
    protected function checkHash(Message $messageObject)
    {
        $messageObject->setSecretKey(
            $this->secretKeyProvider->getSecretKey($messageObject->getClientId())
        );

        if (!$messageObject->isHashValid()) {
            throw new HashMismatchException('The message hash is not valid');
        }
    }

    /**
     * @param ReadMessageEvent $event
     * @param Message          $message
     *
     * @throws MessageNotProcessedException
     */
    protected function checkIfTheMessageWasProcessed(ReadMessageEvent $event, Message $message)
    {
        if ($event === null || !$event->isEventProcessed()) {
            $exception = new MessageNotProcessedException(
                'The given message was not processed by any event!. Message data: ' . $message->getJsonData()
            );
            $exception->setMessageObject($message);

            throw $exception;
        }
    }

    /**
     * @param string     $messageJson
     * @param string     $source
     * @param \Exception $exception
     * @param Message    $message
     */
    public function dispatchErrorEvent(string $messageJson, string $source, \Exception $exception, Message $message)
    {
        $event = new ReadMessageError($messageJson, $source, $exception, $message);
        $this->eventDispatcher->dispatch(Events::READ_MESSAGE_ERROR, $event);
    }
}
