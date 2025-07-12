<?php
session_start();
include '../includes/db.php';

// Check if user is admin
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$check_admin = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = $uid");
$admin = mysqli_fetch_assoc($check_admin);

if (!$admin || !$admin['is_admin']) {
    echo "Access denied.";
    exit();
}

// Fetch pending items
$pending_items = mysqli_query($conn, "SELECT i.*, u.name FROM items i JOIN users u ON i.user_id = u.id WHERE i.status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Panel – ReWear</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<section class="form-section">
  <h2>Admin Panel – Review New Listings</h2>

  <?php if (mysqli_num_rows($pending_items) == 0): ?>
    <p>No pending items.</p>
  <?php else: ?>
    <?php while ($item = mysqli_fetch_assoc($pending_items)): ?>
      <div class="swap-entry">
        <h4><?= htmlspecialchars($item['title']) ?></h4>
        <p><strong>By:</strong> <?= htmlspecialchars($item['name']) ?> | <strong>Category:</strong> <?= $item['category'] ?></p>
        <p><strong>Description:</strong><br><?= nl2br(htmlspecialchars($item['description'])) ?></p>
        <img src="../uploads/<?= $item['image_path'] ?>" width="120" style="margin-top:10px;border-radius:6px;"><br>
        <form method="POST" action="item_action.php">
          <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
          <button name="action" value="approve" class="btn">Approve</button>
          <button name="action" value="reject" class="btn secondary">Reject</button>
        </form>
      </div>
    <?php endwhile; ?>
  <?php endif; ?>
</section>

</body>
</html>
