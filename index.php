<?php
// Загружаем данные из JSON
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);
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
        <?php foreach ($data as $category => $subcategories): ?>
    <?php
    // Получаем URL изображения для категории
    $category_img = $subcategories['category_img'] ?? null;
    ?>
    <div class="category__item">
        <?php if ($category_img): ?>
            <img src="<?php echo $category_img; ?>" alt="<?php echo ucfirst($category); ?>" class="category-img">
        <?php endif; ?>
        <a href="product.php?category=<?php echo urlencode($category); ?>" class="category__title"><?php echo ucfirst($category); ?></a>
    </div>
<?php endforeach; ?>


        </div>
      </section>
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
    <script src="js/index.js"></script>
  </body>
</html>
