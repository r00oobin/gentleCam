<?php

namespace obj\controller;

class DocumentController
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @param $db
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    public function addDocumentToUser($document) {
        $this->db->addDocument($document);
    }

    public function getDocumentByUser($userId) {
        return $this->db->getDocumentsByUser($userId);
    }


}