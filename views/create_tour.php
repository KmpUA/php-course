<?php
global $db;
$db->use_table("tours");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["uploadfile"]["name"]);
    $title = $_POST["title"];
    $price = $_POST["price"];
    $discount = $_POST["discount"];
    $description = $_POST["description"];
    $region = $_POST["region"];
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

    if(empty($target_file)){
        $errors['image'] = "Wrong image file";
    }

    echo gettype($_SESSION["admin"]);

    if (empty($errors)) {
        $db->create(array("src" => $target_file,"title" => $title,"price" => $price,"discount" => $discount, "region" => $region, "description" => $description, "visible" => $_SESSION["admin"], "author_id" => $_SESSION["id"], "rating" => 0));
    }
}
?>


<body>
    <section class="crud_container">
        <h1 class="h1" style="font-size: xx-large">Створити новий тур</h1>
        <form style="width: 100%;" action="index.php?action=create_tour" method="post" enctype="multipart/form-data">
            <div id="wrapper">
                <input id="email" name="title" placeholder="Заголовок" type="text">
                <span class="crud_error"><?= $errors['title'] ?></span>
                <input id="email" name="price" placeholder="Ціна" type="text">
                <span class="crud_error"><?= $errors['price'] ?></span>
                <input id="email" name="discount" placeholder="Знижка" type="text">
                <span class="crud_error"><?= $errors['discount'] ?></span>
                <input id="email" name="region" placeholder="Регіон" type="text">
                <span class="crud_error"><?= $errors['region'] ?></span>
                <input id="email" name="description" placeholder="Опис" type="text">
                <span class="crud_error"><?= $errors['description'] ?></span>
                <h1 class="h1">Завантажити зображення</h1>
                <input id="fileToUpload" style="margin-bottom: 10px" name="uploadfile" placeholder="Зображення" type="file">
                <span class="crud_error"><?= $errors['image'] ?></span>
                <button class="submit-update default-button" type="submit" name="submit">Оновити</button>
            </div>
        </form>
    </section>
</body>
</html>