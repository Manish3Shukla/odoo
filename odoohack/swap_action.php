<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$swap_id = intval($_POST['swap_id']);
$item_id = intval($_POST['item_id']);
$requester_id = intval($_POST['requester_id']);
$action = $_POST['action'];
$method = $_POST['method'];

if ($action === 'approve') {
    // Update swap status
    mysqli_query($conn, "UPDATE swaps SET status = 'approved' WHERE id = $swap_id");
    
    // Update item status
    mysqli_query($conn, "UPDATE items SET status = 'swapped' WHERE id = $item_id");

    // Deduct points if redeeming
    if ($method === 'points') {
        mysqli_query($conn, "UPDATE users SET points = points - 1 WHERE id = $requester_id");
    }

} elseif ($action === 'decline') {
    // Decline swap
    mysqli_query($conn, "UPDATE swaps SET status = 'declined' WHERE id = $swap_id");
}

if ($action === 'approve') {
    mysqli_query($conn, "UPDATE swaps SET status = 'approved' WHERE id = $swap_id");
    mysqli_query($conn, "UPDATE items SET status = 'swapped' WHERE id = $item_id");

    if ($method === 'points') {
        mysqli_query($conn, "UPDATE users SET points = points - 1 WHERE id = $requester_id");
    }

    // Fetch requester email and item
    $result = mysqli_query($conn, "
        SELECT u.email, u.name, i.title 
        FROM users u 
        JOIN swaps s ON s.requester_id = u.id 
        JOIN items i ON s.item_id = i.id 
        WHERE s.id = $swap_id
    ");
    $row = mysqli_fetch_assoc($result);

    $to = $row['email'];
    $subject = "🎉 Your Swap Request Was Approved!";
    $message = "Hi " . $row['name'] . ",\n\nYour request to swap or redeem the item '" . $row['title'] . "' has been approved!\n\nPlease log in to your dashboard to check the details.\n\nThank you for supporting sustainable fashion!\n- ReWear Team";
    $headers = "From: no-reply@rewear.com";

    mail($to, $subject, $message, $headers);
}

    // Get email and item
    $result = mysqli_query($conn, "
        SELECT u.email, u.name, i.title 
        FROM users u 
        JOIN swaps s ON s.requester_id = u.id 
        JOIN items i ON s.item_id = i.id 
        WHERE s.id = $swap_id
    ");
    $row = mysqli_fetch_assoc($result);

    $to = $row['email'];
    $subject = "❌ Swap Request Declined";
    $message = "Hi " . $row['name'] . ",\n\nUnfortunately, your request for the item '" . $row['title'] . "' was declined.\n\nFeel free to browse other available items.\n\n– ReWear Team";
    $headers = "From: no-reply@rewear.com";

    mail($to, $subject, $message, $headers);

    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.example.com'; // e.g. smtp.gmail.com
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@example.com';
    $mail->Password = 'your_password';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('no-reply@rewear.com', 'ReWear');
    $mail->addAddress($to, $row['name']);

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
} catch (Exception $e) {
    error_log("Email could not be sent: {$mail->ErrorInfo}");
}



header("Location: swap_requests.php");
exit();
