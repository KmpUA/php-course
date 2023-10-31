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
?>


<body>
<article style="width: 100%" class="card-container" id="prod1">
    <?php
        if($tour[0]["visible"] == 1 || $_SESSION["admin"] == 1){
            ?>
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
            </article>
        <?php }
    ?>


</article>
</body>
</html>