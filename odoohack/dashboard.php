<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: ../login.php');
  exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($user_query);

// Fetch user's items
$items_query = mysqli_query($conn, "SELECT * FROM items WHERE user_id = $user_id ORDER BY created_at DESC");

// Fetch swaps
$swaps_query = mysqli_query($conn, "
  SELECT s.*, i.title 
  FROM swaps s 
  JOIN items i ON s.item_id = i.id 
  WHERE s.requester_id = $user_id 
  ORDER BY s.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard – ReWear</title>
  <link rel="stylesheet" href="1style.css">
  <link rel="stylesheet" href="1style.css">
</head>
<body>

<header class="dashboard-header">
  <h1>Welcome, <?= htmlspecialchars($user['name']) ?></h1>
  <p>Your Points: <strong><?= $user['points'] ?></strong></p>
  <a href="add_item.php" class="btn">+ Add New Item</a>
</header>

<section class="dashboard-section" data-aos="fade-up">
  <h2>Your Listed Items</h2>
  <div class="item-grid">
    <?php while($item = mysqli_fetch_assoc($items_query)) { ?>
      <div class="item-card" data-aos="zoom-in">
        <img src="../uploads/<?= $item['image_path'] ?>" alt="Item Image">
        <h3><?= htmlspecialchars($item['title']) ?></h3>
        <p><?= htmlspecialchars($item['category']) ?> | <?= $item['size'] ?></p>
        <span class="badge <?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span>
      </div>
    <?php } ?>
  </div>
</section>

<section class="dashboard-section" data-aos="fade-up">
  <h2>Swap Requests</h2>
  <div class="swap-list">
    <?php while($swap = mysqli_fetch_assoc($swaps_query)) { ?>
      <div class="swap-entry" data-aos="fade-left">
        <p><strong><?= htmlspecialchars($swap['title']) ?></strong> – <?= ucfirst($swap['method']) ?> request</p>
        <span class="badge <?= $swap['status'] ?>"><?= ucfirst($swap['status']) ?></span>
        <small><?= date('M d, Y', strtotime($swap['created_at'])) ?></small>
      </div>
    <?php } ?>
  </div>
</section>

<script src="../assets/libs/aos/aos.js"></script>
<script>
  AOS.init();
</script>
</body>
</html>
