<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$uid = $_SESSION['user_id'];
$check = mysqli_query($conn, "SELECT is_admin FROM users WHERE id = $uid");
$admin = mysqli_fetch_assoc($check);

if (!$admin || !$admin['is_admin']) {
    echo "Unauthorized.";
    exit();
}

$item_id = intval($_POST['item_id']);
$action = $_POST['action'];

if ($action === 'approve') {
    mysqli_query($conn, "UPDATE items SET status = 'available' WHERE id = $item_id");
} elseif ($action === 'reject') {
    mysqli_query($conn, "DELETE FROM items WHERE id = $item_id");
}

header("Location: index.php");
exit();
