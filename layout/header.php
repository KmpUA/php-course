<?php
$status = $_SESSION["loggedin"];
$authorizationButton = "Авторизація";
if($status == "true"){
    $authorizationButton = "Вийти";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=3.0, minimum-scale=0.5">
    <link href="css/index.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<!--    <script src="js/subscription.js"></script>-->
<!--    <script src="js/up-button.js"></script>-->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <title>Globetrotter</title>
</head>

<body class="body">
<header>
    <div id="loader"></div>
    <figure class="fir-image-figure">
        <a class="fir-imageover" rel="noopener" target="_blank" href="https://twitter.com/_davideast">
            <img class="fir-author-image fir-clickcircle" src="img/users-logo.png" alt="David East - Author">
            <div class="fir-imageover-color"></div>
        </a>

        <figcaption class="figcaption">
            <?php
            if($status == "true"){?>
                <div class="fig-author-figure-title"><?= $_SESSION["login"] ?></div>
                <div class="fig-author-figure-title"><?php if($_SESSION["admin"] == 0) echo "User"; else echo "Admin";?></div>
                <div class="fig-author-figure-title"><?= $_SESSION["register_date"] ?></div>
        </figcaption>
        <div class="func-btns">
            <button class="adminpanel-btn button-86" role="button" onclick="window.location.href = './adminpanel.html'">Адмін-панель</button>
            <a class="profile-wrapper" href="index.php?action=logout"> <button class="logout-btn button-86" role="button">Вийти</button> </a>
        </div>
            <?php }
            else{?>
                <div class="fig-author-figure-title">Ви не авторизовані!</div>
        </figcaption>
                <div class="func-btns">
                    <button class="adminpanel-btn button-86" role="button" onclick="window.location.href = './adminpanel.html'">Адмін-панель</button>
                    <a class="profile-wrapper" href="index.php?action=login"> <button class="logout-btn button-86" role="button" action="login">Авторизуватися</button> </a>
                </div>
            <?php } ?>




    </figure>
    <div id="subscribe-popup" class="subscribe-popup hidden">
        <div class="subscribe-popup-content">
            <h2>Підписатися на повідомлення</h2>
            <p>Не пропускайте наші новини та акції, підпишіться на наші повідомлення!</p>
            <div class="subscribe-popup-buttons">
                <button id="subscribe-accept" class="default-button" style="margin: 5px;">Підписатися</button>
                <button id="subscribe-reject" class="default-button" style="margin: 5px;">Не зараз</button>
            </div>
        </div>
    </div>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div class="adv-wrapper">
                <img src="img/adv.jpeg" alt="">
                <p>Дорогі абітурієнти!
                    <br>Щиро запрошуємо вас вступити до матечатичного факультету ЧНУ
                    <br>Звертатися за адресою Головна, 119!
                </p>
            </div>
        </div>
    </div>
    <div>
        <a class="slide_button" id="up-btn" href="#">^</a>
    </div>
    <div class="navigation wf-section"></div>
    <div data-collapse="all" data-animation="default" data-duration="400" data-easing="ease-out" data-easing2="ease out"
         role="banner" class="navigation">
        <nav class="navigation-container">
            <a href="index.php?action=main" aria-current="page" class="logo w-inline-block"><img class="logo1" src="img/logo1.png" alt=""></a>
            <div class="hamburger-menu">
                <input id="menu__toggle" type="checkbox" />
                <label class="menu__btn" for="menu__toggle">
                    <span></span>
                </label>
                <ul class="menu__box">
                    <li><a class="menu__item" href="#">Головна</a></li>
                    <li><a class="menu__item" href="#container-meme">Тури</a></li>
                    <li><a class="menu__item" href="../views/about.php">Про нас</a></li>
                    <li><a class="menu__item" href=".#">Інформація</a></li>
                    <li><a class="menu__item" href="index.php?action=login">Авторизація</a></li>
                    <li><a class="menu__item" href="#">Бутстрап</a></li>
                </ul>
            </div>
            <nav role="navigation" class="nav-menu">
                <ul class="topmenu" style="display: flex;flex-direction: row;">
                    <li><a href="index.php?action=main.php#container-meme" class="nav-link">Тури</a>
                        <ul class="submenu">
                            <li><a href="../views/main.php#prod1">Перший блок</a></li>
                            <li><a href="../views/main.php#prod2">Другий блок</a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="nav-link">Інформація</a></li>
                    <li><a href="index.php?action=about" class="nav-link">Про нас</a></li>
                </ul>
            </nav>
            <section class="utils">
                <div class="cart-btn">
                    <i id="cart" class="fas fa-shopping-cart"></i>
                    <span class="cart-quantity">0</span>
                </div>
                <div class="menu-button">
                    <div class="icon-2 w-icon-nav-menu"></div>
                </div>
                <div class="users-card-profile">
                    <img class="users-logo" src="img/users-logo.png" alt="">
                </div>
            </section>
        </nav>
    </div>
</header>
<script src="js/loader.js"></script>
<script src="js/shopping-cart.js"></script>
