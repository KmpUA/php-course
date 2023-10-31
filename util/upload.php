<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


$target_dir = "/var/www/html/php-website/img/";
$target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["uploadfile"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        throw new \Dotenv\Exception\InvalidFileException("File error");
    }
}

if (file_exists($target_file)) {
    $uploadOk = 0;
    throw new \Dotenv\Exception\InvalidFileException("File error");
}

if ($_FILES["uploadfile"]["size"] > 500000000) {
    $uploadOk = 0;
    throw new \Dotenv\Exception\InvalidFileException("File error");

}

if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    $uploadOk = 0;
    throw new \Dotenv\Exception\InvalidFileException("File error");
}

if ($uploadOk == 0) {
    throw new \Dotenv\Exception\InvalidFileException("File error");
} else {
    echo $_FILES["uploadfile"]["tmp_name"];
    if (move_uploaded_file($_FILES["uploadfile"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["uploadfile"]["name"])). " has been uploaded.";
    } else {
        throw new \Dotenv\Exception\InvalidFileException("File error");
    }
}
?>
