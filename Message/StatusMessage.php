<?php

namespace Trinity\Bundle\MessagesBundle\Message;

use Trinity\Bundle\MessagesBundle\Exception\InvalidMessageStatusException;

/**
 * Class StatusMessage.
 *
 * Is used to confirm success or failure of the parent message
 */
class StatusMessage extends Message
{
    private const STATUS_KEY = 'status';
    private const STATUS_MESSAGE_KEY = 'message';

    public const STATUS_OK = 'ok';
    public const STATUS_ERROR = 'error';

    public const MESSAGE_TYPE = 'status';

    /**
     * StatusMessage constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->type = self::MESSAGE_TYPE;
        $this->rawData = [self::STATUS_KEY => self::STATUS_OK, self::STATUS_MESSAGE_KEY => ''];
    }

    /**
     * Encode message to JSON.
     *
     * @return string
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageUserException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageTypeException
     */
    public function pack() : string
    {
        $this->jsonData = json_encode($this->rawData);

        return parent::pack();
    }

    /**
     * Was the parent message ok.
     *
     * @return bool
     */
    public function isOkay() : bool
    {
        return $this->rawData[self::STATUS_KEY] === 'ok';
    }

    /**
     * @param string $statusMessage
     */
    public function setOk(string $statusMessage = 'ok')
    {
        $this->rawData[self::STATUS_KEY] = 'ok';
        $this->rawData[self::STATUS_MESSAGE_KEY] = $statusMessage;
    }

    /**
     * @param string $errorMessage
     */
    public function setError(string $errorMessage)
    {
        $this->rawData[self::STATUS_KEY] = self::STATUS_ERROR;
        $this->rawData[self::STATUS_MESSAGE_KEY] = $errorMessage;
    }

    /**
     * @return string
     */
    public function getStatusMessage() : string
    {
        return $this->rawData[self::STATUS_MESSAGE_KEY];
    }

    /**
     * @param string $statusMessage
     */
    public function setStatusMessage(string $statusMessage)
    {
        $this->rawData[self::STATUS_MESSAGE_KEY] = $statusMessage;
    }

    /**
     * @return string
     */
    public function getStatus() : string
    {
        return $this->rawData[self::STATUS_KEY];
    }

    /**
     * @param string $status
     *
     * @throws InvalidMessageStatusException
     */
    public function setStatus(string $status)
    {
        if (!($status === self::STATUS_OK || $status === self::STATUS_ERROR)) {
            throw new InvalidMessageStatusException(
                "Status '$status' is not valid. Choose one from '".
                self::STATUS_ERROR."' or '".self::STATUS_OK."'"
            );
        }

        $this->rawData[self:: STATUS_KEY] = $status;
    }
}
