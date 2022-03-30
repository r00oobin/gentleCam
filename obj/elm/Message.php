<?php

namespace obj\elm;

class Message
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var int
     */
    private $streamUserId;

    /**
     * @var bool
     */
    private $visible;

    /**
     * @var int
     */
    private $created;

    /**
     * @var string
     */
    private $message;

    /**
     * @var int
     */
    private $coins;

    /**
     * @param int $id
     * @param int $userId
     * @param string $username
     * @param int $streamUserId
     * @param bool $visible
     * @param int $created
     * @param string $message
     * @param int $coins
     */
    public function __construct($id, $userId, $username, $streamUserId, $visible, $created, $message, $coins)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->username = $username;
        $this->streamUserId = $streamUserId;
        $this->visible = $visible;
        $this->created = $created;
        $this->message = $message;
        $this->coins = $coins;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return int
     */
    public function getStreamUserId()
    {
        return $this->streamUserId;
    }

    /**
     * @return bool
     */
    public function isVisible()
    {
        return $this->visible;
    }

    /**
     * @param bool $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCoins()
    {
        return $this->coins;
    }
}