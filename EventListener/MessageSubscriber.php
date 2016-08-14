<?php

namespace Trinity\Bundle\MessagesBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Trinity\Bundle\MessagesBundle\Event\UnpackMessageEvent;
use Trinity\Bundle\MessagesBundle\Reader\MessageReader;

/**
 * Class MessageListener
 * @package Trinity\Bundle\MessagesBundle\EventListener
 */
class MessageSubscriber implements EventSubscriberInterface
{
    /** @var  MessageReader */
    protected $messageReader;

    /**
     * MessageListener constructor.
     *
     * @param MessageReader $messageReader
     */
    public function __construct(MessageReader $messageReader)
    {
        $this->messageReader = $messageReader;
    }

    /**
     * @param UnpackMessageEvent $event
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\DataNotValidJsonException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MessageNotProcessedException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\HashMismatchException
     * @throws \Exception
     */
    public function onUnpackMessageEvent(UnpackMessageEvent $event)
    {
        $this->messageReader->read($event->getMessageJson(), $event->getSource());
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2')))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return [
            UnpackMessageEvent::NAME => 'onUnpackMessageEvent'
        ];
    }
}
