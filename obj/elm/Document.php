<?php

namespace obj\elm;

class Document
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
    private $path;

    /**
     * @var string
     */
    private $name;

    /**
     * @param int $id
     * @param int $userId
     * @param string $path
     * @param string $name
     */
    public function __construct($id, $userId, $path, $name)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->path = $path;
        $this->name = $name;
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
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}