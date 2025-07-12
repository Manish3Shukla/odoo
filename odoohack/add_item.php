<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = $_POST['category'];
    $size = $_POST['size'];
    $condition = $_POST['condition'];
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);

    // Handle image upload
    $imgName = $_FILES['image']['name'];
    $imgTmp = $_FILES['image']['tmp_name'];
    $imgPath = "../uploads/" . basename($imgName);

    if (move_uploaded_file($imgTmp, $imgPath)) {
        $query = "INSERT INTO items (user_id, title, description, category, size, `condition`, tags, image_path) 
                  VALUES ({$_SESSION['user_id']}, '$title', '$description', '$category', '$size', '$condition', '$tags', '$imgName')";
        if (mysqli_query($conn, $query)) {
            $msg = "Item listed successfully!";
        } else {
            $msg = "Error adding item.";
        }
    } else {
        $msg = "Image upload failed.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Item – ReWear</title>
  <link rel="stylesheet" href="2style.css">
  <link rel="stylesheet" href="2style.css">
</head>
<body>

<section class="form-section" data-aos="fade-up">
  <h2>Add a New Item</h2>
  <?php if ($msg) echo "<p class='status-msg'>$msg</p>"; ?>
  <form method="POST" enctype="multipart/form-data" class="add-item-form" data-aos="zoom-in">

    <label>Upload Image</label>
    <input type="file" name="image" accept="image/*" onchange="previewImage(this)" required>
    <img id="preview" style="display:none; width: 150px; margin: 10px 0;" />

    <label>Title</label>
    <input type="text" name="title" required>

    <label>Description</label>
    <textarea name="description" rows="4" required></textarea>

    <label>Category</label>
    <select name="category" required>
      <option>Topwear</option>
      <option>Bottomwear</option>
      <option>Outerwear</option>
      <option>Accessories</option>
    </select>

    <label>Size</label>
    <select name="size" required>
      <option>XS</option>
      <option>S</option>
      <option>M</option>
      <option>L</option>
      <option>XL</option>
    </select>

    <label>Condition</label>
    <select name="condition" required>
      <option>New</option>
      <option>Gently Used</option>
      <option>Worn</option>
    </select>

    <label>Tags (comma-separated)</label>
    <input type="text" name="tags" placeholder="e.g., denim, vintage">

    <button type="submit" class="btn">Submit</button>
  </form>
</section>

<script>
  function previewImage(input) {
    const preview = document.getElementById("preview");
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => {
        preview.src = e.target.result;
        preview.style.display = "block";
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
<script src="../assets/libs/aos/aos.js"></script>
<script>AOS.init();</script>
</body>
</html>
