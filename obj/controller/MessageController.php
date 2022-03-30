<?php

namespace obj\controller;

use obj\elm\Message;


class MessageController
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
     * @param Message $message
     */
    public function messageTransfer($message) {
        if ($message->getCoins() > 0) {
            return $this->coinTransfer($message);
        }
        $message->setVisible(true);
        return $this->db->addMessage($message);
    }

    /**
     * @param Message $message
     */
    private function coinTransfer($message) {
        $message->setVisible(true);
        $user = $this->db->getUserById($message->getUserId());
        if ($user->getCoins() > $message->getCoins()) {
            $isAction = false;
            if ($message->getMessage() == "tip") {
                $isAction = true;
            } else {
                foreach ($this->db->getActionsByUser($message->getStreamUserId()) as $action) {
                    if ($action->getName() == $message->getMessage()) {
                        $isAction = true;
                    }
                }
            }

            if ($isAction) {
                if ($this->db->transferCoins($user->getId(), $message->getStreamUserId(), $message->getCoins())) {
                    return $this->db->addMessage($message);
                }
            }
            return false;
        }
    }

    /**
     * @param $streamUsername
     * @return Message[]
     */
    public function getMessages($streamUsername) {
        if (!isset($_SESSION['streamOpened'])) {
            $date = new \DateTime();
            $_SESSION['streamOpened'] = $date->format('Y-m-d H:i:s');
        }
        $streamOpened = $_SESSION['streamOpened'];

        if (!isset($_SESSION['lastMessage'])) {
            $_SESSION['lastMessage'] = 0;
        }
        $lastMessage = $_SESSION['lastMessage'];

        $messages =  $this->db->getMessageByStreamUsername($streamUsername, $streamOpened, $lastMessage);
        if (sizeof($messages) != 0) {
            $_SESSION['lastMessage'] = $messages[sizeof($messages) - 1]->getId();
        }

        return $messages;

    }
}