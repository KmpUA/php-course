<?php
$action = $_GET["action"];
if($action != "registration") require_once("layout/header.php");
$dirPath = "views";
$files = scandir($dirPath);
$pathFiles = [];
foreach ($files as $file) {
    $filePath = $dirPath . '/' . $file;
    if (is_file($filePath)) {
        $pathFiles[] = $file;
    }
}
$action = $_GET["action"];
if(in_array("$action.php", $pathFiles)){
    require_once ("views/$action.php");
}
else{
    require_once("views/main.php");
}
if($action != "registration") require_once("layout/footer.php");