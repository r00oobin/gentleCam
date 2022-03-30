<?php

namespace obj\elm;

class Viewer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $user_id;

    /**
     * @var int
     */
    private $streamId;

    /**
     * @var int
     */
    private $lastUpdate;

    /**
     * @param int $id
     * @param string $user_id
     * @param int $streamId
     * @param int $lastUpdate
     */
    public function __construct($id, $user_id, $streamId, $lastUpdate)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->streamId = $streamId;
        $this->lastUpdate = $lastUpdate;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * @return int
     */
    public function getStreamId()
    {
        return $this->streamId;
    }

    /**
     * @return int
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }
}