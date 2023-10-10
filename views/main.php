<?php
global $db;
$db->use_table("tours");
$array = $db->get("src", "price", "title", "region", "discount", "description", "author_id", "visible");
?>
                                                                                                                                    a
<main>
    <div class="header-content">
      <h1 class="h1">
        Почни подорожувати сьогодні
      </h1>
      <p>Найкраща пропозиція на ринку туристичних послуг.</p>
      <a action="main" class="button-product one"
        style="width: 40%; background-color:rgba(12, 100, 103, 0.6);color:white;">Перейти до
        інформації</a>
    </div>
    <div class="cart-modal-overlay">
      <div class="cart-modal">
        <i id="close-btn" class="fas fa-times"></i>
        <div class="cart-buttons">
          <button id="sort-by-name" class="button-86" role="button">Sort by Name</button>
          <button id="sort-by-price" class="button-86" role="button">Sort by Price</button>
        </div>
        <h1 class="cart-is-empty">Кошик порожній</h1>

        <div class="product-rows">
        </div>
        <div class="total">
          <h1 class="cart-total">Всього</h1>
          <span class="total-price">$0</span>
          <button class="purchase-btn">Придбати</button>
        </div>
      </div>
    </div>
    <section class="main-filter-container">
      <div class="ranger-wrapper">
        <div class="price-input">
          <div class="field">
            <span>Min</span>
              <input type="number" class="input-min" value="0">
          </div>
          <div class="separator">-</div>
          <div class="field">
            <span>Max</span>
              <input type="number" class="input-max" value="2500">
          </div>
        </div>
        <div class="ranger-slider">
          <div class="progress"></div>
        </div>
        <div class="range-input">
            <input type="range" class="range-min" min="0" max="2500" value="0" step="100">
            <input type="range" class="range-max" min="0" max="2500" value="2500" step="100">
        </div>
      </div>
      <div class="search-container">
        <div class="sort-container">
            <input type="text" class="search-input" placeholder="Шукаємо..." />
          <label for="sort-select"></label><select id="sort-select">
            <option value=1>від дешевих до дорогих</option>
            <option value=2>від дорогих до дешевих</option>
            <option value=3>по назві</option>
          </select>
        </div>

        <div class="filters">
          <button class="filter-btn button-86" data-region="Європа">Europe</button>
          <button class="filter-btn button-86" data-region="Азія">Asia</button>
          <button class="filter-btn button-86" data-region="Америка">America</button>
        </div>
      </div>
    </section>
    <section class="aside-wrapper">
      <article class="card-container" id="prod1">
          <?php
          foreach ($array as $tour => $tour_value){
              if($tour_value["visible"] == 1){
              ?>
                  <article class="card" draggable="true">
              <div class="image-container-discount">
                  <img class="product-image" src="<?= $tour_value["src"] ?>" alt="Туристичне місце">`;
                  <div class="discount"><?= $tour_value["discount"] . "%"?></div>
              </div>
                <div class="card-info">
                    <h2 class="card-title"><?= $tour_value["title"] ?></h2>
                    <p class="product-price"><?= $tour_value["price"] . "$" ?></p>
                    <div class="add_buttons">
                        <button class="card-btn">Детальніше</button>
                        <button class="add-to-cart card-btn-style">Додати в кошик</button>
                        <div style="font-size: xx-large" class="card-price">
                            <?php $db->use_table("users");
                                $author = $tour_value["author_id"];
                                $result = $db->find("user_id = $author");
                                echo "Автор: " . $result[0]["user_login"];
                            ?></div>
                    </div>
                    <div class="card-description">
                    <p id="desc">
                        <?= $tour_value["description"] ?></p>
                    </div>
                    <div class="region" style="display:none;"><?= $tour_value["region"] ?></div>
                </div>
                  </article>
          <?php }}
          ?>

      </article>
    </section>
    <div class="pagination">
      <div id="page-buttons"></div>
    </div>
  <div class="slider">
    <div class="slide">
      <p>Арабські емірати</p>
    </div>
    <div class="slide">
      <p>Турція</p>
    </div>
    <div class="slide">
      <p>Канада</p>
    </div>
    <div class="slide">
      <p>Франція</p>
    </div>
    <div class="slide">
      <p>США</p>
    </div>
  </div>
</main>
<script src="js/load-images.js"></script>
<script src="js/aside.js"></script>
<script src="js/cards.js"></script>