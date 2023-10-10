<?php
require_once("vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();
require_once("util/database_model.php");
$db = new DatabaseModel();
session_start();
$action = $_GET["action"];
if($action != "registration" && $action != "login" && $action != "logout") require_once("layout/header.php");
$action = $_GET["action"];
if(file_exists("views/$action.php")){
    require_once ("views/$action.php");
}
else{
    require_once("views/main.php");
}
if($action != "registration" && $action != "login") require_once("layout/footer.php");