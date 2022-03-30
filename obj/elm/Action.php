<?php

namespace obj\elm;

class Action
{

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $user_id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $coins;

    /**
     * @param int $id
     * @param int $user_id
     * @param string $name
     * @param int $coins
     */
    public function __construct($id, $user_id, $name, $coins)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->name = $name;
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
        return $this->user_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getCoins()
    {
        return $this->coins;
    }
}