<?php

namespace obj\controller;

class LogController
{
    /**
     * @var string
     */
    private $path;

    public function __construct()
    {
        $this->path = "/var/www/log/log.txt";
    }

    public function log($ip, $action, $site, $input, $user = null) {
        $file = fopen($this->path, 'a');
        $date = new \DateTime();
        if ($user == null) {
            $user = "guest";
        }
        fwrite($file, $date->format('Y-m-d H:i:s') . " - " . $user . " " . $ip . " - " . $site . " "  . $action . " : " . $input);
        fclose($file);
    }

}