<?php

namespace obj\controller;

use obj\controller\Database;
use obj\elm\User;
use obj\elm\Viewer;

class StreamController
{
    /**
     * @var Database
     */
    private $db;

    /**
     *
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @return User[]
     */
    public function getAllStreams() {
        $stats = file_get_contents("http://202.61.248.90:8080/stat");
        $data = simplexml_load_string($stats);
        $streams = $data->server->application->live->stream;

        $users = [];
        if (!isset($_SESSION['streams'])) {
            $_SESSION['streams'] = [];
        }
        foreach($streams as $stream) {
            $user = $this->db->getUserByStreamingKey($stream->name);
            if ($user) {
                $users[] = $user;
            }
        }
        return $users;
    }

    /**
     * @param $streamerUsername
     * @return User
     */
    public function getStream($streamerUsername) {
        return $this->db->getUserByUsername($streamerUsername);

    }

    /**
     * @param $streamId
     * @return Viewer[]
     */
    public function getViewers($streamId) {
        $this->updateViewer($streamId);
        return $this->db->getViewersByStream($streamId);
    }

    /**
     * @param $userId
     * @param $streamId
     */
    public function addViewer($userId, $streamId) {
        $this->db->updateViewer($userId, $streamId);
    }

    /**
     * @param $streamId
     */
    public function updateViewer($streamId) {
        $viewers = $this->db->getViewersByStream($streamId);
        $date = new \DateTime();
        $date->modify("-10 second");
        $date = $date->format('Y-m-d H:i:s');
        foreach ($viewers as $viewer) {
            if ($viewer->getLastUpdate() <= $date) {
                $this->db->removeViewer($viewer->getUserId());
            }
        }
    }

}