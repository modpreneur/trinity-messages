<?php

namespace Trinity\Bundle\MessagesBundle\Interfaces;

use Trinity\Bundle\MessagesBundle\Message\Message;

/**
 * Interface MessageLoggerInterface.
 */
interface MessageLoggerInterface
{
    /**
     * Log a message. This should log all incoming and outcoming messages.
     *
     * @param Message $messageObject Message to be logged
     * @param string  $messageJson   Message represented as json
     * @param string  $source        Source(e.g. server, client_1, etc.) of the message (= who has sent the message)
     * @param string  $destination   Destination of the message (e.g. server, client_1, etc.) (= who should receive the
     *                               message)
     * @param string  $status        Status of the message(ok, error).
     * @param string  $error         Error message from the message(if provided)
     *
     * @return
     */
    public function logMessage(
        Message $messageObject = null,
        string $messageJson = '',
        string $source = '',
        string $destination = '',
        string $status = '',
        string $error = ''
    );

    /**
     * Log a dead lettered message. The message was not accepted by the receiver. Set it's status to error.
     *
     * @param Message $messageObject Message to be logged
     * @param string  $messageJson   Message represented as json
     * @param string  $source        Source(e.g. server, client_1, etc.) of the message (= who has sent the message)
     * @param string  $destination   Destination of the message (e.g. server, client_1, etc.) (= who should receive the
     *                               message)
     */
    public function logDeadLetteredMessage(
        Message $messageObject = null,
        string $messageJson = '',
        string $source = '',
        string $destination = ''
    );

    /**
     * Set status of the message with $messageId to $status.
     *
     * @param string $messageId     Message id
     * @param string $status        Status of the message(ok, error)
     * @param string $statusMessage Additional message to the status(practically additional information for 'error'
     *                              status).
     */
    public function setMessageStatus(
        string $messageId,
        string $status,
        string $statusMessage
    );
}
