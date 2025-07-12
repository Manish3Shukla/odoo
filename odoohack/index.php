<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ReWear – Clothing Exchange</title>
  <link rel="stylesheet" href="assets/css/style.css" />
  <link rel="stylesheet" href="assets/libs/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="assets/libs/aos/aos.css" />
</head>
<body>

  <header class="hero-section">
    <nav>
      <div class="logo">ReWear</div>
      <ul class="nav-links">
        <li><a href="#carousel">Browse Items</a></li>
        <li><a href="user/add_item.php">List an Item</a></li>
        <li><a href="login.php">Login</a></li>
      </ul>
    </nav>
    <div class="hero-content" data-aos="fade-up">
      <h1>Swap. Save. Sustain.</h1>
      <p>Join ReWear and give your clothes a second life.</p>
      <a href="register.php" class="btn">Start Swapping</a>
    </div>
  </header>

  <section class="featured-section" id="carousel">
    <h2 data-aos="fade-up">Featured Items</h2>
    <div class="swiper mySwiper" data-aos="zoom-in">
      <div class="swiper-wrapper">
        <!-- Dynamic PHP content -->
        <?php
        include 'includes/db.php';
        $query = "SELECT * FROM items WHERE status='available' LIMIT 5";
        $result = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($result)) {
          echo '
          <div class="swiper-slide">
            <div class="item-card">
              <img src="uploads/' . $row['image_path'] . '" alt="Item">
              <h3>' . htmlspecialchars($row['title']) . '</h3>
              <p>' . htmlspecialchars($row['category']) . ' | Size: ' . $row['size'] . '</p>
              <a href="item/view.php?id=' . $row['id'] . '" class="view-btn">View</a>
            </div>
          </div>';
        }
        ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </section>

  <footer>
    <p>© 2025 ReWear – Swap Sustainably</p>
  </footer>

  <script src="assets/libs/swiper/swiper-bundle.min.js"></script>
  <script src="assets/libs/aos/aos.js"></script>
  <script src="assets/js/main.js"></script>
</body>
</html>
i