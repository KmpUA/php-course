<?php
global $db;
$db->use_table("tours");
$tour_id = 0;
$tour[0] = 0;

if(isset($_GET['id']) && is_numeric($_GET['id'])){
    $tour_id = $_GET['id'];
    $tour = $db->find("id = $tour_id");
    if(!$tour){
        ?>
        <h1 style="text-align: center" class="h1">Tour is not found!</h1>
        <?php
        throw new mysqli_sql_exception("Tour is not found");
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($tour){
        $confirmation = $_POST['confirm_delete'] ?? false;
        if ($confirmation) {
            $db->delete("id=$tour_id");
            echo '<script>alert("Тур успішно видалено!")</script>';
        }
        else{
            echo '<script>alert("Видалення скасовано!")</script>';
        }
    }
}
?>


<body>
<article style="width: 100%" class="card-container" id="prod1">
    <?php
    if($tour[0]["visible"] == 1 || $_SESSION["admin"] == 1){
        ?>
        <form onsubmit="return confirm('Ви впевнені, що хочете видалити тур?');" style="width: 100%; display: flex; flex-direction: column; justify-content:center; align-items: center" action="index.php?action=delete_tour&id=<?= $tour_id ?>" method="post" enctype="multipart/form-data">
        <article class="card" draggable="true">
            <div class="image-container-discount">
                <img class="product-image" src="<?= $tour[0]["src"] ?>" alt="Туристичне місце">`;
                <div class="discount"><?= $tour[0]["discount"] . "%"?></div>
            </div>
            <div class="card-info">
                <h2 class="card-title"><?= $tour[0]["title"] ?></h2>
                <p class="product-price"><?= $tour[0]["price"] . "$" ?></p>
                <div class="add_buttons">
                    <button class="card-btn">Детальніше</button>
                    <button class="add-to-cart card-btn-style">Додати в кошик</button>
                    <div style="font-size: xx-large" class="card-price">
                        <?php $db->use_table("users");
                        $author = $tour[0]["author_id"];
                        $result = $db->find("user_id = $author");
                        $stars = str_repeat("★", $tour[0]["rating"]);
                        echo "Автор: " . $result[0]["user_login"] . "<br>Rating: " . $stars;
                        ?></div>
                </div>
                <div class="card-description">
                    <p id="desc">
                        <?= $tour[0]["description"] ?></p>
                </div>
                <div class="region" style="display:none;"><?= $tour[0]["region"] ?></div>
            </div>
            <input type="hidden" name="confirm_delete" value="1">
            <button style="margin: 10px;" class="submit-update default-button" type="submit" name="submit">Видалити</button>
        </article>
        </form>
    <?php }
    ?>



</article>
</body>
</html>