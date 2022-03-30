<?php

namespace obj\controller;

class ConfigController
{
    /**
     * @var string
     */
    private static $configFile = "/var/www/html/config/config.json";

    /**
     * @return mixed
     */
    public static function getConfig() {
        $content = file_get_contents(ConfigController::$configFile);
        return json_decode($content);
    }
}