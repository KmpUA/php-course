<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$errors = array();
global $db;
$db->use_table("tours");
$tour_id = 0;
$tour = 0;

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $tour_id = $_GET['id'];
    $tour = $db->find("id = $tour_id");
    if(!$tour){
        throw new mysqli_sql_exception("Tour is not found");
    }
}
/**
 * @param mixed $title
 * @param array $errors
 * @param mixed $price
 * @param mixed $discount
 * @param mixed $description
 * @param mixed $region
 * @param string $target_file
 * @return array
 */
function checkFields(mixed $title, array $errors, mixed $price, mixed $discount, mixed $description, mixed $region, string $target_file): array
{
    if (empty($title) || strlen($title) < 3) {
        $errors['title'] = "Wrong title!";
    }

    if (!is_numeric($price) || $price <= 0) {
        $errors['price'] = "Price must be a numeric value.";
    }

    if (!is_numeric($discount) || $discount > 0) {
        $errors['discount'] = "Discount must be a less 0.";
    }

    if (empty($description) || strlen($description) < 10) {
        $errors['description'] = "Wrong description!";
    }

    if ($region != "Америка" && $region != "Азія" && $region != "Європа") {
        $errors['region'] = "Wrong region!";
    }

    if (empty($target_file)) {
        $errors['image'] = "Wrong image file";
    }
    return $errors;
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $target_dir = "img/";
    if(basename($_FILES["uploadfile"]["name"]) !== "") $target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
    else $target_file = $tour[0]["src"];
    $title = $_POST["title"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];
    $region = $_POST["region"];
    $author_id = $_POST["author_id"];
    $visible = $_POST["visible"];
    $rating = $_POST["rating"];
    $errors = checkFields($title, $errors, $price, $discount, $description, $region, $target_file);
    if (empty($errors)) {
        $db->update(array("src" => $target_file,"title" => $title,"price" => $price,"discount" => $discount, "region" => $region, "description" => $description, "visible" => $visible, "author_id" => $author_id, "rating" => $rating), "id = $tour_id"); ?>
        <script>
            window.location.replace("http://localhost/php-website/index.php?action=main");
        </script>
    <?php }
}
?>


<body>
<?php
if(!isset($_SESSION["loggedin"])){?>
    <script>
        window.location.replace("http://localhost/php-website/index.php?action=main");
    </script>
<?php }
?>
<section class="crud_container">
    <h1 class="h1" style="font-size: xx-large">Оновити тур</h1>
    <form style="width: 100%;" action="index.php?action=update_tour&id=<?= $tour_id ?>" method="post" enctype="multipart/form-data">
        <div id="wrapper">
            <p class="card-price">Назва туру</p>
            <input id="email" value="<?= $tour[0]['title'] ?>" name="title" placeholder="Заголовок" type="text">
            <span class="crud_error"><?= $errors['title'] ?></span>
            <p class="card-price">Ціна</p>
            <input id="email" value="<?= $tour[0]['price'] ?>" name="price" placeholder="Ціна" type="text">
            <span class="crud_error"><?= $errors['price'] ?></span>
            <p class="card-price">Знижка</p>
            <input id="email" value="<?= $tour[0]['discount'] ?>" name="discount" placeholder="Знижка" type="text">
            <span class="crud_error"><?= $errors['discount'] ?></span>
            <p class="card-price">Частина світу</p>
            <input id="email" value="<?= $tour[0]['region'] ?>" name="region" placeholder="Регіон" type="text">
            <span class="crud_error"><?= $errors['region'] ?></span>
            <p class="card-price">Опис</p>
            <input id="email" value="<?= $tour[0]['description'] ?>" name="description" placeholder="Опис" type="text">
            <span class="crud_error"><?= $errors['description'] ?></span>
            <p class="card-price">Автор</p>
            <input id="email" value="<?= $tour[0]['author_id'] ?>" name="author_id" placeholder="Заголовок" type="text">
            <span class="crud_error"><?= $errors['title'] ?></span>
            <p class="card-price">Видимість</p>
            <input id="email" value="<?= $tour[0]['visible'] ?>" name="visible" placeholder="Заголовок" type="text">
            <span class="crud_error"><?= $errors['title'] ?></span>
            <p class="card-price">Рейтинг</p>
            <input id="email" value="<?= $tour[0]['rating'] ?>" name="rating" placeholder="Заголовок" type="text">
            <span class="crud_error"><?= $errors['title'] ?></span>
            <p class="card-price">Зображення</p>
            <h1 class="h1">Завантажити зображення</h1>
            <input id="fileToUpload" value="<?= "img/" . $tour[0]['src'] ?>" style="margin-bottom: 10px" name="uploadfile" placeholder="Зображення" type="file">
            <span class="crud_error"><?= $errors['image'] ?></span>
            <button class="submit-update default-button" type="submit" name="submit">Оновити</button>
        </div>
    </form>
</section>
</body>
</html>