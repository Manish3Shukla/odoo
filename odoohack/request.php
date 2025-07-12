<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['item_id'], $_POST['method'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = intval($_POST['item_id']);
$method = $_POST['method'] === 'points' ? 'points' : 'swap';

// Prevent duplicate requests
$check = mysqli_query($conn, "SELECT * FROM swaps WHERE requester_id = $user_id AND item_id = $item_id");
if (mysqli_num_rows($check) > 0) {
    header("Location: ../item/view.php?id=$item_id&msg=already_requested");
    exit();
}

// Create swap request
mysqli_query($conn, "INSERT INTO swaps (requester_id, item_id, method, status) VALUES ($user_id, $item_id, '$method', 'pending')");
header("Location: ../user/dashboard.php");
exit();
