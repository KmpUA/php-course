<?php
require_once("init.php");
$action = $_GET["action"];
if($action != "registration" && $action != "login" && $action != "logout") require_once("layout/header.php");
if(file_exists("views/$action.php")){
    require_once ("views/$action.php");
}
else{
    require_once("views/main.php");
}
if($action != "registration" && $action != "login") require_once("layout/footer.php");