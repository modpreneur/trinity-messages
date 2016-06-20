<?php

namespace Trinity\Bundle\MessagesBundle\Event;

/**
 * Class Events
 * @package Trinity\Bundle\MessagesBundle\Event
 */
final class Events
{
    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\AfterUnpackMessageEvent")
     */
    const AFTER_MESSAGE_UNPACKED = 'trinity.messages.afterUnpackMessage';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\BeforeMessagePublishEvent")
     */
    const BEFORE_MESSAGE_PUBLISH = 'trinity.messages.beforeMessagePublish';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\ReadMessageErrorEvent")
     */
    const READ_MESSAGE_ERROR     = 'trinity.messages.readMessageError';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\ReadMessageEvent")
     */
    const READ_MESSAGE           = 'trinity.messages.readMessage';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\SendMessageEvent")
     */
    const SEND_MESSAGE           = 'trinity.messages.sendMessage';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\SetMessageStatusEvent")
     */
    const SET_MESSAGE_STATUS     = 'trinity.messages.setMessageStatus';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\StatusMessageEvent")
     */
    const STATUS_MESSAGE_EVENT   = 'trinity.messages.statusMessageEvent';

    /**
     * @Event("Trinity\Bundle\MessagesBundle\Event\UnpackMessageEvent")
     */
    const UNPACK_MESSAGE         = 'trinity.messages.unpackMessage';
}