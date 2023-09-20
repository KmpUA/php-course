<?php
require_once ("/var/www/html/php-website/layout/header.php");
$dirPath = "/var/www/html/php-website/views";
$files = scandir($dirPath);
$pathFiles = [];
foreach ($files as $file) {
    $filePath = $dirPath . '/' . $file;
    if (is_file($filePath) && $file != "index.php") {
        $pathFiles[] = $file;
    }
}
$action = $_GET["action"];
if(in_array("$action.php", $pathFiles)){
    require_once ("/var/www/html/php-website/views/$action.php");
}
else{
    require_once ("/var/www/html/php-website/views/main.php");
}
require_once ("/var/www/html/php-website/layout/footer.php");