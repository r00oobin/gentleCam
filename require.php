<?php
session_start();

include_once "/var/www/html/obj/controller/ConfigController.php";
include_once "/var/www/html/obj/controller/Database.php";
include_once "/var/www/html/obj/controller/DocumentController.php";
include_once "/var/www/html/obj/controller/LogController.php";
include_once "/var/www/html/obj/controller/MessageController.php";
include_once "/var/www/html/obj/controller/StreamController.php";
include_once "/var/www/html/obj/controller/UserController.php";

include_once "/var/www/html/obj/elm/Action.php";
include_once "/var/www/html/obj/elm/Document.php";
include_once "/var/www/html/obj/elm/Message.php";
include_once "/var/www/html/obj/elm/Tag.php";
include_once "/var/www/html/obj/elm/User.php";
include_once "/var/www/html/obj/elm/Viewer.php";