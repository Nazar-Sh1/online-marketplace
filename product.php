<?php
// Получаем параметры из URL
$category = $_GET['category'] ?? null;         // Категория (например, ElectroTehnica)
$subcategory = $_GET['subcategory'] ?? null;   // Подкатегория (например, Laptops или Phones)
$brand = $_GET['brand'] ?? null;               // Бренд (например, Apple, HP)

// Загружаем данные из JSON
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

// Проверяем, существует ли категория
if (!$category || !isset($data[$category])) {
    echo "<h1>Категория не найдена</h1>";
    exit;
}

// Получаем данные для выбранной категории
$categoryData = $data[$category];

// Получаем изображение для категории, если оно есть
$category_img = $categoryData['category_img'] ?? null;
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Магазин техніки "Матільда"</title>
    <link
      rel="shortcut icon"
      type="image/png"
      href="img/icone/logo.png"
      sizes="16x16"
    />
    <link rel="stylesheet" href="css/styles.css" />
    <script
      src="https://unpkg.com/htmx.org@1.9.10"
      integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC"
      crossorigin="anonymous"
    ></script>
  </head>
    <body>
    <header class="header">
      <nav
        class="header__nav"
        data-hx-trigger="load"
        data-hx-swap="outerHTML"
        data-hx-get="global.header-nav.partial.html"
      ></nav>
      <div class="header__video">
        <video class="header__video-element" autoplay muted loop>
          <source src="video/iphone-presentation.mp4" type="video/mp4" />
          Your browser does not support video. Update it or use another one.
        </video>
      </div>
    </header>

    <main class="main-content">
      <section class="category">
        <div class="category__grid">
        <?php
// Шаг 1: Если не выбрана подкатегория, показываем подкатегории (например, Laptops, Phones)
if (!$subcategory) {
    foreach ($categoryData as $subcategoryName => $brands) {
        if ($subcategoryName === 'category_img') {
            continue;  // Игнорируем category_img на этом уровне
        }
        
        if (is_array($brands)) {
            // Получаем изображение для подкатегории, если оно существует
            $subcategory_img = $brands['subcategory_img'] ?? null;

            echo "<div class='category__item'>";
            // Если изображение подкатегории существует, выводим его
            if ($subcategory_img) {
                echo "<img src='{$subcategory_img}' alt='{$subcategoryName}' class='category__image'>";
            }
            echo "<a href='product.php?category=" . urlencode($category) . "&subcategory=" . urlencode($subcategoryName) . "' class='category__title'>" . ucfirst($subcategoryName) . "</a>";
            echo "</div>";
        }
    }
}

// Шаг 2: Если выбрана подкатегория, показываем бренды
if ($subcategory && !$brand && isset($categoryData[$subcategory])) { // Проверка, что бренд не выбран
  foreach ($categoryData[$subcategory] as $brandName => $products) {
      // Пропускаем ключи 'category_img' и 'subcategory_img', так как это не бренд
      if ($brandName === 'category_img' || $brandName === 'subcategory_img') {
          continue;
      }

      // Получаем изображение бренда
      $brand_img = $products['brand_img'] ?? null;

      echo "<div class='category__item'>";
      // Если изображение бренда существует, выводим его
      if ($brand_img) {
          echo "<img src='{$brand_img}' alt='{$brandName}' class='category__image'>";
      }
      echo "<a href='product.php?category=" . urlencode($category) . "&subcategory=" . urlencode($subcategory) . "&brand=" . urlencode($brandName) . "' class='category__title'>" . ucfirst($brandName) . "</a>";
      echo "</div>";
  }
}




// Шаг 3: Если выбрана подкатегория и бренд, показываем товары
if ($subcategory && $brand && isset($categoryData[$subcategory][$brand])) {
  // Скрытие предыдущих блоков с уровня 3
  echo "<div class='products__section'>"; // Для разделения блока с товарами

  foreach ($categoryData[$subcategory][$brand] as $productName => $product) {
      // Пропускаем ключи типа 'brand_img', потому что это не товар
      if ($productName === 'brand_img') {
          continue;
      }

      // Проверка и вывод данных товара
      if (is_array($product) && isset($product['img'], $product['name'], $product['price'], $product['id'])) {
          echo "<div class='product__item'>";
          
          // Вывод изображения товара, если оно есть
          if (!empty($product['img'])) {
              echo "<img src='{$product['img']}' alt='{$product['name']}' class='product__image' width='150'>";
          } else {
              echo "<img src='default_image.jpg' alt='No image available' class='product__image' width='150'>";
          }
          
          echo "<h3 class='product__name'>{$product['name']}</h3>";
          echo "<p class='product__price'>Цена: {$product['price']}</p>";
          echo "<p class='product__description'>Описание: {$product['description']}</p>";
          echo "<p class='product__delivery'>Доставка: {$product['delivery']}</p>";
          echo "</div>";
      } else {
          // Ошибка, если данные товара некорректны
          echo "<p>Ошибка: данные товара некорректны для '{$productName}'</p>";
          var_dump($product); // Для отладки, покажет содержимое $product
      }
  }

  echo "</div>"; // Закрытие блока товаров
}




?> 

        </div>
      </section>
      <div class="parting"></div>
    </main>


<section class="product-ratings">
        <h2 class="product-ratings__title">Product ratings</h2>
        <div class="product-ratings__grid">
          <div class="product-ratings__item">
            <a href="#" class="product-ratings__link">
              <img
                src="img/photo/electronics-top.jfif"
                alt="Electronics Top"
                class="product-ratings__image"
              />
              <p class="product-ratings__text">Electronics Rating</p>
            </a>
          </div>
          <div class="product-ratings__item">
            <a href="#" class="product-ratings__link">
              <img
                src="img/photo/household-goods-top.jfif"
                alt="Household Goods Top"
                class="product-ratings__image"
              />
              <p class="product-ratings__text">Household Goods Rating</p>
            </a>
          </div>
          <div class="product-ratings__item">
            <a href="#" class="product-ratings__link">
              <img
                src="img/photo/gaming-top.jfif"
                alt="Gaming Top"
                class="product-ratings__image"
              />
              <p class="product-ratings__text">Gaming Rating</p>
            </a>
          </div>
          <div class="product-ratings__item">
            <a href="#" class="product-ratings__link">
              <img
                src="img/photo/smart-home-top.jfif"
                alt="Smart Home Top"
                class="product-ratings__image"
              />
              <p class="product-ratings__text">Smart Home Rating</p>
            </a>
          </div>
        </div>
      </section>
      <section
        class="carousel"
        data-hx-trigger="load"
        data-hx-swap="outerHTML"
        data-hx-get="carousel.partial.html"
      ></section>
      <div class="parting"></div>
      <section
        class="carousel"
        data-hx-trigger="load"
        data-hx-swap="outerHTML"
        data-hx-get="carousel.partial.html"
      ></section>
      <div class="parting"></div>
    </main>
    <footer class="footer">
      <nav
        class="footer__nav"
        data-hx-trigger="load"
        data-hx-swap="outerHTML"
        data-hx-get="global.footer.partial.html"
      ></nav>
    </footer>

    <script>
    // Функция для показа/скрытия уровней
    function showLevel(level, brand) {
        // Скрыть все уровни
        document.querySelectorAll('.level-3, .level-4').forEach(function(element) {
            element.style.display = 'none';
        });

        // Показать выбранный уровень
        if (level == 4) {
            // Показываем товары для выбранного бренда
            document.querySelectorAll('.products').forEach(function(product) {
                product.style.display = 'none';  // Скрыть все товары
            });
            document.getElementById('products-for-' + brand).style.display = 'block'; // Показываем товары для выбранного бренда
        }
    }

    // Если вам нужно загрузить данные с сервера, можно использовать AJAX здесь.
</script>

</body>
</html>
