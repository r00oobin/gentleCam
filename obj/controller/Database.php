<?php

namespace obj\controller;

use obj\elm\Action;
use obj\elm\Document;
use obj\elm\Message;
use obj\elm\Tag;
use obj\elm\User;
use obj\elm\Viewer;

/**
 * Database connection
 */
class Database
{
    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $db;

    /**
     * @var \mysqli
     */
    private $conn;

    /**
     *
     */
    public function __construct()
    {
        $dbConfig = ConfigController::getConfig()->db;
        $this->host = $dbConfig->host;
        $this->user = $dbConfig->user;
        $this->db = $dbConfig->name;
        $this->pass = $dbConfig->password;
        $this->conn = $this->getConnected($this->host, $this->user, $this->pass, $this->db);
    }

    /**
     * @param $row
     * @return User
     */
    private function createUser($row) {
        return  new User(
            $row["id"],
            $row["username"],
            $row["email"],
            $row["password"],
            $row['birthday'],
            $row['description'],
            $this->getSex($row['sex']),
            $row['height'],
            $row['weight'],
            $row['skincolor'],
            $row['haircolor'],
            $row["coins"],
            $row["active"],
            $row["lastlogging"],
            $row["created"],
            $row["role"],
            $row["streamKey"],
            $this->getDocumentsByUserId($row["id"]),
            $row["ban"],
            $row["thumbnail"],
            $this->getCountry($row["country"]),
            $this->getLanguage($row["language"]),
            $row["profilepicture"],
            $row["anonym"],
            $row["instagramname"],
            $row["percent"],
            $this->getActionsByUser($row["id"]),
            $this->getTagsByUser($row["id"])
        );
    }

    /**
     * @param $host
     * @param $user
     * @param $pass
     * @param $db
     * @return \mysqli|void
     */
    private function getConnected($host,$user,$pass,$db) {

        $mysqli = new \mysqli($host, $user, $pass, $db);

        if($mysqli->connect_error)
            die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());

        return $mysqli;
    }

    /**
     * @param $login
     * @param $password
     * @return false|User
     */
    public function login($login, $password) {
        $sql = "SELECT * FROM user WHERE username = '$login' AND password = '$password' AND active = 1";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
               return $this->createUser($row);
            }
        } else {
            $sql = "SELECT * FROM user WHERE email = '$login' AND password = '$password' AND active = 1";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    return $this->createUser($row);
                }
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     */
    public function register($username, $email, $password) {
        // prepare and bind
        $stmt = $this->conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        return $stmt->execute();
    }

    public function checkRegister($username, $email) {
        if ($this->getUserByUsername($username)) {
            return "username";
        }
        if ($this->getUserByEmail($email)) {
            return "email";
        }
        return true;
    }

    public function getBank() {
        $sql = "SELECT * FROM user WHERE username = 'bank'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $this->createUser($row);
            }
        } else {
            return false;
        }
    }
    /**
     * @param $username
     * @return User
     */
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM user WHERE username = '$username' AND active = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $this->createUser($row);
            }
        } else {
            return false;
        }
    }

    /**
     * @param $streamKey
     * @return User
     */
    public function getUserByStreamingKey($streamKey) {
        $sql = "SELECT * FROM user WHERE streamKey = '$streamKey' AND active = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $this->createUser($row);
            }
        } else {
            return false;
        }
    }

    /**
     * @param $email
     * @return User
     */
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM user WHERE email = '$email' AND active = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $this->createUser($row);
            }
        } else {
            return false;
        }
    }

    /**
     * @param $userId
     * @return array
     */
    private function getDocumentsByUserId($userId) {
        $sql = "SELECT * FROM documents WHERE user_id = $userId";
        $result = $this->conn->query($sql);

        $documents = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $documents[] = new Document($row["id"], $row["user_id"], $row["path"], $row["name"]);
            }
        }
        return $documents;
    }

    /**
     * @param $userId
     * @param $ip
     * @return bool
     */
    public function addIp($userId, $ip) {
        $ips = $this->getIpByUserId($userId);
        if (!in_array($ip, $ips)) {
            $stmt = $this->conn->prepare("INSERT INTO ip (user_id, ip) VALUES (?, ?)");
            $stmt->bind_param("is", $userId, $ip);
            return $stmt->execute();
        }
        return false;
    }

    /**
     * @param $userId
     * @return array
     */
    public function getIpByUserId($userId) {
        $sql = "SELECT * FROM ip WHERE user_ID = $userId";
        $result = $this->conn->query($sql);
        $ips = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $ips[] = $row['ip'];
            }
        }
        return $ips;
    }

    /**
     * @param $id
     * @return User
     */
    public function getUserById($id) {
        $sql = "SELECT * FROM user WHERE id = $id AND active = 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $this->createUser($row);
            }
        } else {
            return false;
        }
    }

    /**
     * @param $userId
     * @param $receiveId
     * @param $amount
     * @return bool
     */
    public function transferCoins($userId, $receiveId, $amount) {
        $user = $this->getUserById($userId);
        $receiveUser = $this->getUserById($receiveId);
        if (!$user) {
            return false;
        }
        if (!$receiveUser) {
            return false;
        }


        $diff = $user->getCoins() - $amount;
        $sql = "UPDATE user SET coins=$diff WHERE id=$userId";
        $this->conn->query($sql);

        $receiveUser = $this->getUserById($receiveId);
        $receiveAmount = intval(round($amount / 100 * $receiveUser->getPercent(), 0));
        $diff = $receiveUser->getCoins() + $receiveAmount;
        $sql = "UPDATE user SET coins=$diff WHERE id=$receiveId";
        $this->conn->query($sql);

        $transfer = $amount - $receiveAmount;
        $bank = $this->getBank();
        $diff = $bank->getCoins() + $transfer;
        $sql = "UPDATE user SET coins=$diff WHERE id=1";
        $this->conn->query($sql);
        return true;
    }

    /**
     * @param $user_id
     * @return Action[]
     */
    public function getActionsByUser($user_id) {

        $sql = "SELECT * FROM action WHERE user_id = $user_id";

        $result = $this->conn->query($sql);

        $actions = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $actions[] = new Action($row['id'], $row['user_id'], $row['name'], $row['coins']);
            }
        }
        return $actions;
    }

    /**
     * @param $user_id
     * @return Tag[]
     */
    public function getTagsByUser($user_id) {

        $sql = "SELECT * FROM user_tags WHERE user_id = $user_id";

        $result = $this->conn->query($sql);

        $tags = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $tags[] = new Tag($row['tag_id'], $this->getTagById($row['tag_id']));
            }
        }
        return $tags;
    }



    /**
     * @param $user_id
     *
     */
    public function getActionsByUserAndName($user_id, $name) {

        $sql = "SELECT * FROM action WHERE user_id = $user_id AND name = '$name'";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row['id'];
            }
        }
        return null;
    }

    /**
     * @param $user_id
     * @param $name
     * @param $coins
     * @return bool
     */
    public function hasAction($user_id, $name, $coins){
        if ($name = "tip") {
            return true;
        }
        $sql = "SELECT * FROM action WHERE user_id = $user_id AND name = '$name' AND coins = $coins";

        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $user_id
     * @param $name
     * @param $coins
     * @return bool
     */
    public function addAction($user_id, $name, $coins) {
        $stmt = $this->conn->prepare("INSERT INTO action (user_id, name, coins) VALUES (?, ?, ?)");

        $stmt->bind_param("isi", $user_id, $name, $coins);

        return $stmt->execute();
    }

    /**
     * @param $streamUsername
     * @return Message[]
     *
     */
    public function getMessageByStreamUsername($streamUsername, $streamOpened, $lastMessage) {

        $user = $this->getUserByUsername($streamUsername);

        $streamUserId = $user->getId();
        $sql = "SELECT * FROM message WHERE streamUserId = $streamUserId AND created > '$streamOpened' AND id > $lastMessage";

        $result = $this->conn->query($sql);

        $messages = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $messageUser = $this->getUserById($row['user_id']);
                $messages[] = new Message($row['id'], $row['user_id'], $messageUser->getUsername(), $row['streamUserId'], $row['visible'], $row['created'], $row['message'], $row['coins']);
            }
        } else {
            return $messages;
        }
        return $messages;
    }

    /**
     * @param Message $message
     */
    public function addMessage($message) {
        $stmt = $this->conn->prepare("INSERT INTO message (user_id, streamUserId, visible, message, coins) VALUES (?, ?, ?, ?, ?)");

        $userId = $message->getUserId();
        $streamUserId = $message->getStreamUserId();
        $visible = $message->isVisible();
        $text = $message->getMessage();
        $coins = $message->getCoins();

        $stmt->bind_param("iiisi", $userId, $streamUserId, $visible, $text, $coins);

        return $stmt->execute();
    }

    /**
     * @param $userId
     * @param $streamUserId
     * @return bool
     */
    public function addViewer($userId, $streamUserId) {
        $stmt = $this->conn->prepare("INSERT INTO viewer (user_id, streamer_id) VALUES (?, ?)");

        $stmt->bind_param("si", $userId, $streamUserId);

        return $stmt->execute();
    }

    /**
     * @param $userId
     * @param $streamerUserId
     */
    public function updateViewer($userId, $streamerUserId) {
        $this->removeViewer($userId);
        $this->addViewer($userId, $streamerUserId);
    }

    /**
     * @param $userId
     */
    public function removeViewer($userId) {
        $sql = "DELETE FROM viewer WHERE user_id= '$userId'";
        $this->conn->query($sql);
    }

    /**
     * @param $streamerUserId
     * @return Viewer[]
     */
    public function getViewersByStream($streamerUserId) {
        $sql = "SELECT * FROM viewer WHERE streamer_id = $streamerUserId";
        $result = $this->conn->query($sql);
        $viewers = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $viewers[] = new Viewer($row['id'], $row['user_id'], $row['streamer_id'], $row['lastUpdate']);
            }
        }
        return $viewers;
    }

    /**
     * @param User $user
     */
    public function updateUser($user) {

        $stmt = $this->conn->prepare("UPDATE user SET username=?, email=?, password=?, coins=?, active=?, role=?, streamKey=?, ban=?, birthday=?, description=?, sex=?, height=?, weight=?, skincolor=?, haircolor=?, thumbnail=?, country=?, language=?, profilepicture=?, anonym=?, instagramname=? WHERE id=?");
        $stmt->bind_param("sssiissssssiissssssisi", $username, $email, $password, $coins, $active, $role, $streamKey, $ban, $birthday, $description, $sex, $height, $weight, $skinColor, $hairColor, $thumbnail, $country, $language, $profilePicutre, $annonym, $instagramName, $userId);

        $userId = $user->getId();
        $username = $user->getUsername();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $coins = $user->getCoins();
        $active = $user->isActive();
        $role = $user->getRole();
        $streamKey = $user->getStreamKey();
        $ban = $user->getBan();
        $birthday = $user->getBirthday();
        $description = $user->getDescription();
        $sex = $user->getSex();
        $height = $user->getHeight();
        $weight = $user->getWeight();
        $skinColor = $user->getSkinColor();
        $hairColor = $user->getHairColor();
        $thumbnail = $user->getThumbnail();
        $country = $user->getCountry();
        $language = $user->getLanguage();
        $profilePicutre = $user->getProfilePicture();
        $annonym = $user->isAnonym();
        $instagramName = $user->getInstagramName();

        $stmt->execute();

    }

    /**
     * @param $user_id
     */
    public function updateLastLogging($user_id) {
        $stmt = $this->conn->prepare("UPDATE user SET lastlogging=? WHERE id=?");
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $stmt->bind_param("si", $date, $user_id);
        $stmt->execute();
    }

    /**
     * @param int $user_id
     * @param Document $document
     */
    public function addDocument($document) {
        $stmt = $this->conn->prepare("INSERT INTO documents (user_id, path, name) VALUES (?, ?, ?)");

        $stmt->bind_param("iss", $user_id, $path, $name);

        $user_id = $document->getUserId();
        $path = $document->getPath();
        $name = $document->getName();

        return $stmt->execute();
    }

    /**
     * @param $user_id
     * @return Document[]
     */
    public function getDocumentsByUser($user_id) {
        $sql = "SELECT * FROM documents WHERE user_id = $user_id";
        $result = $this->conn->query($sql);

        $documents = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $documents[] = new Document($row['id'], $row['user_id'], $row['path'], $row['name']);
            }
        }
        return $documents;
    }

    /**
     * @param $username
     * @param $email
     * @param $password
     * @return bool
     */
    public function createShopUser($username, $email, $password) {
        $conn = $this->getConnected($this->host, $this->user, $this->pass, 'wordpress_shop');
        $stmt = $conn->prepare("INSERT INTO wp_users (user_login, user_nicename, user_pass, user_email) VALUES (?, ?, ?, ?)");

        $stmt->bind_param("ssss", $username, $nicename, $password, $email);
        $nicename = $username;

        $stmt->execute();
        return true;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function createNewStreamerRequest($user_id) {
        $stmt = $this->conn->prepare("INSERT INTO streamerRequest (user_id) VALUES (?)");

        $stmt->bind_param("i", $user_id);

        $stmt->execute();
        return true;
    }

    /**
     * @param $user_id
     * @param $tag_id
     * @return bool
     */
    public function addTag($user_id, $tag_id) {
        $stmt = $this->conn->prepare("INSERT INTO user_tags (user_id, tag_id) VALUES (?, ?)");

        $stmt->bind_param("ii", $user_id, $tag_id);

        $stmt->execute();
        return true;
    }

    /**
     * @param $id
     */
    public function removeTag($user_id, $tag_id) {
        $sql = "DELETE FROM user_tags WHERE user_id= $user_id AND tag_id = $tag_id";
        $this->conn->query($sql);
    }

    /**
     * @param $id
     */
    public function removeAction($id) {
        $sql = "DELETE FROM action WHERE id= $id";
        $this->conn->query($sql);
    }


    public function getLanguage($id) {
        $sql = "SELECT * FROM language WHERE id = '$id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row['name'];
            }
        }
        return null;
    }

    public function getCountry($id) {
        $sql = "SELECT * FROM country WHERE id = '$id'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row['name'];
            }
        }
        return null;
    }

    public function getLanguages() {
        $sql = "SELECT * FROM language";
        $result = $this->conn->query($sql);

        $languages = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $languages[$row['id']] = $row['name'];
            }
        }
        return $languages;
    }

    public function getSkinColor() {
        $sql = "SELECT * FROM skincolor";
        $result = $this->conn->query($sql);

        $skincolors = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $skincolors[$row['color']] = $row['hex'];
            }
        }
        return $skincolors;
    }

    public function getHairColor() {
        $sql = "SELECT * FROM haircolor";
        $result = $this->conn->query($sql);

        $haircolors = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $haircolors[$row['color']] = $row['hex'];
            }
        }
        return $haircolors;
    }

    public function getCountries() {
        $sql = "SELECT * FROM country";
        $result = $this->conn->query($sql);

        $countries = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $countries[$row['id']] = $row['name'];
            }
        }
        return $countries;
    }

    public function getSex($id) {
        $sql = "SELECT * FROM sex WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row['name'];
            }
        }
        return null;
    }

    public function getAllSex() {
        $sql = "SELECT * FROM sex";
        $result = $this->conn->query($sql);

        $sexs = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $sexs[$row['id']] = $row['name'];
            }
        }
        return $sexs;
    }

    public function getTags() {
        $sql = "SELECT * FROM tags";
        $result = $this->conn->query($sql);

        $tags = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $tags[] = new Tag($row['id'], $row['name']);
            }
        }

        return $tags;
    }

    public function getTag($name) {
        $sql = "SELECT * FROM tags WHERE name = '$name'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return new Tag($row['id'], $row['name']);
            }
        }
        return null;
    }

    public function getTagById($id) {
        $sql = "SELECT * FROM tags WHERE id = $id";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                return $row['name'];
            }
        }
        return null;
    }
}