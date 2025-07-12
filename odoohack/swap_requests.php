<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch swap requests for your items
$query = mysqli_query($conn, "
  SELECT s.*, u.name AS requester_name, i.title 
  FROM swaps s 
  JOIN items i ON s.item_id = i.id 
  JOIN users u ON s.requester_id = u.id 
  WHERE i.user_id = $user_id 
  ORDER BY s.created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Swap Requests – ReWear</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<section class="form-section">
  <h2>Swap Requests for Your Items</h2>
  <?php while ($row = mysqli_fetch_assoc($query)) { ?>
    <div class="swap-entry">
      <p>
        <strong><?= htmlspecialchars($row['requester_name']) ?></strong> requested <strong><?= $row['method'] ?></strong> for 
        "<em><?= htmlspecialchars($row['title']) ?></em>"
        (<?= $row['status'] ?>)
      </p>
      <?php if ($row['status'] == 'pending'): ?>
        <form method="POST" action="swap_action.php">
          <input type="hidden" name="swap_id" value="<?= $row['id'] ?>">
          <input type="hidden" name="item_id" value="<?= $row['item_id'] ?>">
          <input type="hidden" name="requester_id" value="<?= $row['requester_id'] ?>">
          <input type="hidden" name="method" value="<?= $row['method'] ?>">
          <button name="action" value="approve" class="btn">Approve</button>
          <button name="action" value="decline" class="btn secondary">Decline</button>
        </form>
      <?php endif; ?>
    </div>
  <?php } ?>
</section>

</body>
</html>
