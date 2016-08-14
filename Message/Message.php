<?php

namespace Trinity\Bundle\MessagesBundle\Message;

use Trinity\Bundle\MessagesBundle\Exception\DataNotValidJsonException;
use Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException;
use Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException;
use Trinity\Bundle\MessagesBundle\Exception\MissingMessageTypeException;
use Trinity\Bundle\MessagesBundle\Exception\MissingMessageUserException;
use Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException;

/**
 * Class Message.
 */
class Message
{
    const UID_KEY = 'uid';
    const DATA_KEY = 'data';
    const HASH_KEY = 'hash';
    const CLIENT_ID_KEY = 'clientId';
    const CREATED_AT_KEY = 'createdAt';
    const MESSAGE_TYPE_KEY = 'messageType';
    const PARENT_MESSAGE_UID_KEY = 'parent';
    const SENDER_KEY = 'sender';
    const DESTINATION_KEY = 'destination';
    const USER_KEY = 'user';

    const MESSAGE_TYPE = 'message';

    /** @var  string */
    protected $uid;

    /** @var string */
    protected $clientId = '';

    /** @var  string */
    protected $secretKey = '';

    /** @var  string */
    protected $jsonData = '';

    /** @var  mixed Data in raw format(numbers, objects, arrays) */
    protected $rawData;

    /** @var  int */
    protected $createdAt;

    /** @var  string */
    protected $hash = '';

    /** @var  string */
    protected $type = '';

    /** @var  string */
    protected $parentMessageUid = '';

    /** @var  string */
    protected $sender = '';

    /** @var  string */
    protected $destination = '';

    /** @var  string Identification of the user who sent this message. */
    protected $user = '';

    /**
     * Message constructor.
     */
    public function __construct()
    {
        $this->type = self::MESSAGE_TYPE;
        $this->uid = uniqid('', true);
        $this->createdAt = time();
    }

    /**
     * Make hash from the object's data.
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     */
    public function makeHash()
    {
        if (!$this->secretKey) {
            throw new MissingSecretKeyException('No client secret defined while trying to make hash.');
        }

        if (!$this->clientId) {
            throw new MissingClientIdException('No client id defined while trying to make hash.');
        }

        $this->hash = hash(
            'sha256',
            implode(
                ',',
                [
                    $this->uid,
                    $this->clientId,
                    json_encode($this->jsonData),
                    $this->createdAt,
                    $this->secretKey,
                    $this->type,
                    $this->parentMessageUid,
                    $this->sender,
                    $this->destination,
                    $this->user,
                ]
            )
        );
    }

    /**
     * Check if the current hash is equal to newly generated hash.
     *
     * @return bool
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingSecretKeyException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingClientIdException
     */
    public function isHashValid() : bool
    {
        $oldHash = $this->hash;
        $this->makeHash();

        return $oldHash === $this->hash;
    }

    /**
     * Encode message to JSON or array.
     *
     * @param bool $getAsArray
     *
     * @return string
     *
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageDestinationException
     * @throws \Trinity\Bundle\MessagesBundle\Exception\MissingMessageUserException
     * @throws MissingClientIdException
     * @throws MissingMessageTypeException
     * @throws MissingSecretKeyException
     */
    public function pack(bool $getAsArray = false) : string
    {
        if ($this->type === '') {
            throw new MissingMessageTypeException('Trying to pack a message without type');
        }

        if ($this->user === '') {
            throw new MissingMessageUserException();
        }

        if ($this->destination === '') {
            throw new MissingMessageDestinationException('Message does not have destination');
        }

        if ($this->jsonData === '') {
            $this->jsonData = \json_encode($this->rawData);
        }

        $this->makeHash();

        if ($getAsArray === true) {
            return $this->getAsArray();
        } else {
            return $this->getAsJson();
        }
    }

    /**
     * Unpack message.
     *
     * Method can not have return type because PHP sucks... @see https://wiki.php.net/rfc/return_types
     *
     * @param string $messageJson
     *
     * @return Message
     *
     * @throws DataNotValidJsonException
     */
    public static function unpack(string $messageJson)
    {
        $messageObject = new self();

        $messageArray = \json_decode($messageJson, true);

        if ($messageArray === null) {
            throw new DataNotValidJsonException('Could not convert JSON to Message');
        }

        $messageObject->type = $messageArray[self::MESSAGE_TYPE_KEY];
        $messageObject->uid = $messageArray[self::UID_KEY];
        $messageObject->clientId = $messageArray[self::CLIENT_ID_KEY];
        $messageObject->createdAt = (int) $messageArray[self::CREATED_AT_KEY];
        $messageObject->hash = $messageArray[self::HASH_KEY];
        $messageObject->jsonData = $messageArray[self::DATA_KEY];
        $messageObject->rawData = \json_decode($messageObject->jsonData, true);
        $messageObject->parentMessageUid = $messageArray[self::PARENT_MESSAGE_UID_KEY];
        $messageObject->destination = $messageArray[self::DESTINATION_KEY];
        $messageObject->sender = $messageArray[self::SENDER_KEY];
        $messageObject->user = $messageArray[self::USER_KEY];

        return $messageObject;
    }

    /**
     * Get the Message as json.
     *
     * @return string
     */
    protected function getAsJson() : string
    {
        return json_encode(
            $this->getAsArray()
        );
    }

    /**
     * Get the message as array.
     *
     * @return array
     */
    protected function getAsArray()
    {
        return [
            self::MESSAGE_TYPE_KEY => $this->type,
            self::UID_KEY => $this->uid,
            self::CLIENT_ID_KEY => $this->clientId,
            self::CREATED_AT_KEY => $this->createdAt,
            self::HASH_KEY => $this->hash,
            self::DATA_KEY => $this->jsonData,
            self::PARENT_MESSAGE_UID_KEY => $this->parentMessageUid,
            self::SENDER_KEY => $this->sender,
            self::DESTINATION_KEY => $this->destination,
            self::USER_KEY => $this->user,
        ];
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public function copyTo(Message $message)
    {
        $message->type = $this->type;
        $message->uid = $this->uid;
        $message->clientId = $this->clientId;
        $message->createdAt = $this->createdAt;
        $message->hash = $this->hash;
        $message->jsonData = $this->jsonData;
        $message->parentMessageUid = $this->parentMessageUid;
        $message->rawData = $this->rawData;
        $message->sender = $this->sender;
        $message->destination = $this->destination;
        $message->user = $this->user;

        return $message;
    }

    /**
     * @param Message $message
     *
     * @return Message
     */
    public static function createFromMessage(Message $message)
    {
        $returnMessage = new self();

        $message->copyTo($returnMessage);

        return $returnMessage;
    }

    /**
     * @return string
     */
    public function getUid() : string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     */
    public function setUid(string $uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return string
     */
    public function getClientId() : string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getSecretKey() : string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @return int
     */
    public function getCreatedAt() : int
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|int $createdAt DateTime or timestamp(which is converted to datetime internally)
     */
    public function setCreatedAt($createdAt)
    {
        if ($createdAt instanceof \DateTime) {
            $this->createdAt = $createdAt->getTimestamp();
        } elseif (is_int($createdAt)) {
            $this->createdAt = (int) $createdAt;
        }
    }

    /**
     * @return string
     */
    public function getHash() : string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash)
    {
        $this->hash = $hash;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getJsonData() : string
    {
        return $this->jsonData;
    }

    /**
     * @param string $jsonData
     */
    public function setJsonData(string $jsonData)
    {
        $this->jsonData = $jsonData;
    }

    /**
     * @return mixed
     */
    public function getRawData()
    {
        return $this->rawData;
    }

    /**
     * @param mixed $rawData
     */
    public function setRawData($rawData)
    {
        $this->rawData = $rawData;
    }

    /**
     * @return string
     */
    public function getParentMessageUid() : string
    {
        return $this->parentMessageUid;
    }

    /**
     * @param string $parentMessageUid
     */
    public function setParentMessageUid(string $parentMessageUid)
    {
        $this->parentMessageUid = $parentMessageUid;
    }

    /**
     * @return string
     */
    public function getSender() : string
    {
        return $this->sender;
    }

    /**
     * @param string $sender
     */
    public function setSender(string $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getDestination() : string
    {
        return $this->destination;
    }

    /**
     * @param string $destination
     */
    public function setDestination(string $destination)
    {
        $this->destination = $destination;
    }

    /**
     * @return string
     */
    public function getUser() : string
    {
        return $this->user;
    }

    /**
     * @param string $user
     */
    public function setUser(string $user)
    {
        $this->user = $user;
    }
}
