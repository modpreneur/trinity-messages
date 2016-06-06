<?php

namespace Trinity\Bundle\MessagesBundle\Event;

/**
 * Class Events
 * @package Trinity\Bundle\MessagesBundle\Event
 */
final class Events
{
    const SEND_MESSAGE = 'trinity.messages.sendMessage';
    const READ_MESSAGE = 'trinity.messages.readMessage';
    const UNPACK_MESSAGE = 'trinity.messages.unpackMessage';
    const AFTER_MESSAGE_UNPACKED = 'trinity.messages.afterUnpackMessage';
    const READ_MESSAGE_ERROR = 'trinity.messages.readMessageError';
}