<?php

namespace obj\controller;

use obj\elm\User;

class UserController
{
    /**
     * @var Database
     */
    private $db;

    /**
     * @var User
     */
    private $user;

    /**
     * @param $db
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->auth();
    }

    /**
     * @return bool
     */
    private function auth() {
        $secretUsername = null;
        $secretPassword = null;
        if (isset($_SESSION['secretUsername'])) {
            $secretUsername = $_SESSION['secretUsername'];
        } else {
            return false;
        }
        if (isset($_SESSION['secretPassword'])) {
            $secretPassword = $_SESSION['secretPassword'];
        } else {
            return false;
        }

        $user = $this->db->login($secretUsername, $secretPassword);

        if (!$user) {
            return false;
        } else {
            $this->user = $user;
            $this->addIp();
            return true;
        }
    }

    /**
     *
     */
    private function addIp() {
        $this->db->addIp($this->getUser()->getId(), $_SERVER['REMOTE_ADDR']);
    }

    /**
     * @param $login
     * @param $password
     * @return bool|string
     */
    public function login($login, $password) {

        $response = $this->db->login($login, $password);

        if (!$response) {
            return "Logging False";
        } else {
            if (!$response->getBan()) {
                $_SESSION['secretUsername'] = $response->getUsername();
                $_SESSION['secretPassword'] = $response->getPassword();
                $this->user = $response;

                $this->db->updateLastLogging($response->getId());

                return true;
            } else {
                return "Banned";
            }
        }
    }

    public function updateUser($user) {
        $this->db->updateUser($user);
    }


    /**
     * @param $username
     * @param $email
     * @param $password
     * @return bool|string
     */
    public function register($username, $email, $password) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $checkRegister = $this->db->checkRegister($username, $email);
            if ($checkRegister === "username") {
                return "username already exists";
            } else if ($checkRegister === "email") {
                return "email already exists";
            } else if ($this->db->register($username, $email, $password)) {
                $this->db->createShopUser($username, $email, md5($password));
                return true;
            } else {
                return "error";
            }
        } else {
            return "invalid email";
        }
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}