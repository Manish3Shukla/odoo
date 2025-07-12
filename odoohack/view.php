<?php
session_start();
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: ../index.php');
    exit();
}

$item_id = intval($_GET['id']);

// Fetch item
$item_q = mysqli_query($conn, "SELECT i.*, u.name AS uploader FROM items i JOIN users u ON i.user_id = u.id WHERE i.id = $item_id");
$item = mysqli_fetch_assoc($item_q);

if (!$item) {
    echo "Item not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($item['title']) ?> – ReWear</title>
  <link rel="stylesheet" href="3style.css">
  <link rel="stylesheet" href="3style.css">
</head>
<body>

<section class="item-detail-container" data-aos="fade-in">
  <div class="item-image">
    <img src="../uploads/<?= $item['image_path'] ?>" alt="<?= htmlspecialchars($item['title']) ?>">
  </div>
  <div class="item-info">
    <h2><?= htmlspecialchars($item['title']) ?></h2>
    <p><strong>Category:</strong> <?= $item['category'] ?></p>
    <p><strong>Size:</strong> <?= $item['size'] ?></p>
    <p><strong>Condition:</strong> <?= $item['condition'] ?></p>
    <p><strong>Tags:</strong> <?= htmlspecialchars($item['tags']) ?></p>
    <p><strong>Uploaded By:</strong> <?= htmlspecialchars($item['uploader']) ?></p>
    <p><strong>Status:</strong> <span class="badge <?= $item['status'] ?>"><?= ucfirst($item['status']) ?></span></p>

    <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($item['description'])) ?></p>

    <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $item['user_id'] && $item['status'] === 'available') : ?>
      <div class="action-buttons">
        <form action="../swap/request.php" method="POST">
          <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
          <button type="submit" name="method" value="swap" class="btn">Request Swap</button>
          <button type="submit" name="method" value="points" class="btn secondary">Redeem via Points</button>
        </form>
      </div>
    <?php elseif (!isset($_SESSION['user_id'])): ?>
      <p><a href="../login.php" class="btn">Log in to request</a></p>
    <?php else: ?>
      <p><em>No actions available.</em></p>
    <?php endif; ?>
  </div>
</section>

<script src="../assets/libs/aos/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
