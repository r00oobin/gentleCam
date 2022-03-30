<?php

namespace obj\elm;

class User
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var int
     */
    private $birthday;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $sex;

    /**
     * @var int
     */
    private $height;

    /**
     * @var int
     */
    private $weight;

    /**
     * @var string
     */
    private $skinColor;

    /**
     * @var string
     */
    private $hairColor;
    /**
     * @var int
     */
    private $coins;

    /**
     * @var bool
     */
    private $active;

    /**
     * @var int
     */
    private $lastLogging;

    /**
     * @var int
     */
    private $created;

    /**
     * @var string
     */
    private $role;

    /**
     * @var string
     */
    private $streamKey;

    /**
     * @var Document[]
     */
    private $documents;

    /**
     * @var string
     */
    private $ban;

    /**
     * @var string
     */
    private $thumbnail;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $language;

    /**
     * @var string
     */
    private $profilePicture;

    /**
     * @var bool
     */
    private $anonym;

    /**
     * @var string
     */
    private $instagramName;

    /**
     * @var int
     */
    private $percent;

    /**
     * @var Action[]
     */
    private $actions;


    /**
     * @var array
     */
    private $tags;

    /**
     * @param int $id
     * @param string $username
     * @param string $email
     * @param string $password
     * @param int $birthday
     * @param string $description
     * @param string $sex
     * @param int $height
     * @param int $weight
     * @param string $skinColor
     * @param string $hairColor
     * @param int $coins
     * @param bool $active
     * @param int $lastLogging
     * @param int $created
     * @param string $role
     * @param string $streamKey
     * @param Document[] $documents
     * @param string $ban
     * @param string $thumbnail
     * @param string $country
     * @param string $language
     * @param string $profilePicture
     * @param bool $anonym
     * @param string $instagramName
     * @param int $percent
     * @param Action[] $actions
     * @param Tag[] $tags
     */
    public function __construct($id, $username, $email, $password, $birthday, $description, $sex, $height, $weight, $skinColor, $hairColor, $coins, $active, $lastLogging, $created, $role, $streamKey, array $documents, $ban, $thumbnail, $country, $language, $profilePicture, $anonym, $instagramName, $percent, $actions, $tags)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->birthday = $birthday;
        $this->description = $description;
        $this->sex = $sex;
        $this->height = $height;
        $this->weight = $weight;
        $this->skinColor = $skinColor;
        $this->hairColor = $hairColor;
        $this->coins = $coins;
        $this->active = $active;
        $this->lastLogging = $lastLogging;
        $this->created = $created;
        $this->role = $role;
        $this->streamKey = $streamKey;
        $this->documents = $documents;
        $this->ban = $ban;
        $this->thumbnail = $thumbnail;
        $this->country = $country;
        $this->language = $language;
        $this->profilePicture = $profilePicture;
        $this->anonym = $anonym;
        $this->instagramName = $instagramName;
        $this->percent = $percent;
        $this->actions = $actions;
        $this->tags = $tags;
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
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return int
     */
    public function getCoins()
    {
        return $this->coins;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return int
     */
    public function getLastLogging()
    {
        return $this->lastLogging;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getStreamKey()
    {
        return $this->streamKey;
    }

    /**
     * @return Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @return string
     */
    public function getBan()
    {
        return $this->ban;
    }

    /**
     * @return int
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getSkinColor()
    {
        return $this->skinColor;
    }

    /**
     * @return string
     */
    public function getHairColor()
    {
        return $this->hairColor;
    }

    /**
     * @return bool
     */
    public function isStreamer()
    {
        if ($this->getStreamKey() != null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        if ($this->getStreamKey() != null) {
            if(file_get_contents("/var/www/html/stream/hls/" . $this->getStreamKey() . ".m3u8") == "") {
                return false;
            } else {
                return true;
            }
        }
    }

    /**
     * @return string
     */
    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @return bool
     */
    public function isAnonym()
    {
        return $this->anonym;
    }

    /**
     * @return string
     */
    public function getInstagramName()
    {
        return $this->instagramName;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param int $birthday
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param string $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @param int $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * @param int $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @param string $skinColor
     */
    public function setSkinColor($skinColor)
    {
        $this->skinColor = $skinColor;
    }

    /**
     * @param string $hairColor
     */
    public function setHairColor($hairColor)
    {
        $this->hairColor = $hairColor;
    }

    /**
     * @param int $coins
     */
    public function setCoins($coins)
    {
        $this->coins = $coins;
    }

    /**
     * @param bool $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @param int $lastLogging
     */
    public function setLastLogging($lastLogging)
    {
        $this->lastLogging = $lastLogging;
    }

    /**
     * @param int $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @param string $streamKey
     */
    public function setStreamKey($streamKey)
    {
        $this->streamKey = $streamKey;
    }

    /**
     * @param Document[] $documents
     */
    public function setDocuments($documents)
    {
        $this->documents = $documents;
    }

    /**
     * @param string $ban
     */
    public function setBan($ban)
    {
        $this->ban = $ban;
    }

    /**
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @param bool $anonym
     */
    public function setAnonym($anonym)
    {
        $this->anonym = $anonym;
    }

    /**
     * @param string $instagramName
     */
    public function setInstagramName($instagramName)
    {
        $this->instagramName = $instagramName;
    }

    /**
     * @return int
     */
    public function getPercent()
    {
        return $this->percent;
    }

    /**
     * @return Action[]
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }


}