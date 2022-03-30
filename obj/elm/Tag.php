<?php

namespace obj\elm;

class Tag
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $name;

    /**
     * @param int $id
     * @param int $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
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
    public function getName()
    {
        return $this->name;
    }
}