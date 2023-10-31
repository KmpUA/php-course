<?php
global $db;
$db->use_table("tours");
$array = $db->get("src", "price", "title", "region", "discount", "description", "author_id", "visible", "date", "id");
usort($array, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>

<body>
<section class="crud_container">
    <h1 class="h1" style="font-size: xx-large">Список турів</h1>
    <table class="styled-table">
        <thead>
        <tr>
            <th>Title</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Region</th>
            <th>Author</th>
            <th>Visible</th>
            <th>Description</th>
            <?php if($_SESSION["admin"] == 1){?>
            <th>Actions</th>
            <?php } ?>
            <th>Image</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($array as $tour_v => $tour) :
            if(!$tour["visible"] && !$_SESSION["admin"]){ continue ;}?>
            <tr class="active-row">
                <td><?= $tour['title'] ?></td>
                <td><?= $tour['price'] ?></td>
                <td><?= -$tour['discount'] . "%" ?></td>
                <td><?= $tour['region'] ?></td>
                <td><?php $db->use_table("users");
                    $author = $tour["author_id"];
                    $result = $db->find("user_id = $author");
                    echo "Автор: " . $result[0]["user_login"];
                    $db->use_table("tours");
                    ?></td>
                <td><?= $tour['visible'] ?></td>
                <td><?= $tour['description'] ?></td>
                <?php if($_SESSION["admin"] == 1){?>
                <td style="width: 10%">
                    <a href="index.php?action=view_tour&id=<?= $tour["id"] ?>"><svg width="50px" height="50px" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation"><path d="M12,9C10.34,9 9,10.34 9,12C9,13.66 10.34,15 12,15C13.66,15 15,13.66 15,12C15,10.34 13.66,9 12,9M12,17C9.24,17 7,14.76 7,12C7,9.24 9.24,7 12,7C14.76,7 17,9.24 17,12C17,14.76 14.76,17 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"></path></svg></a>
                    <a href="index.php?action=update_tour&id=<?= $tour["id"] ?>"><svg width="50px" height="50px" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation"><path d="M16.84,2.73C16.45,2.73 16.07,2.88 15.77,3.17L13.65,5.29L18.95,10.6L21.07,8.5C21.67,7.89 21.67,6.94 21.07,6.36L17.9,3.17C17.6,2.88 17.22,2.73 16.84,2.73M12.94,6L4.84,14.11L7.4,14.39L7.58,16.68L9.86,16.85L10.15,19.41L18.25,11.3M4.25,15.04L2.5,21.73L9.2,19.94L8.96,17.78L6.65,17.61L6.47,15.29"></path></svg></a>
                    <a href="index.php?action=delete_tour&id=<?= $tour["id"] ?>"><svg width="50px" height="50px" focusable="false" viewBox="0 0 24 24" aria-hidden="true" role="presentation"><path d="M9,3V4H4V6H5V19C5,20.1 5.9,21 7,21H17C18.1,21 19,20.1 19,19V6H20V4H15V3H9M7,6H17V19H7V6M9,8V17H11V8H9M13,8V17H15V8H13Z"></path></svg></a>
                </td>
                <?php } ?>
                <td><img src="<?= $tour['src'] ?>" alt="Tour Image" style="width: 200px;"></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>
</body>
</html>