<?php
session_start();
include 'config.php';

// ADD NEW PERFUME
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $top = $_POST['top_notes'];
    $heart = $_POST['heart_notes'];
    $base = $_POST['base_notes'];
    $desc = $_POST['description'];
    $image = $_POST['image_url'];

    $stmt = $conn->prepare("INSERT INTO perfumes (name, top_notes, heart_notes, base_notes, description, image_url) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $top, $heart, $base, $desc, $image);

    if ($stmt->execute()) {
        echo "<p style='color:lightgreen; text-align:center;'>✅ Perfume added successfully.</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>❌ Failed to add perfume: " . $stmt->error . "</p>";
    }
}


if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<link rel="stylesheet" href="style.css">

<div class="admin-top-bar">
  <div class="admin-welcome">🌟 Welcome, Admin <?php echo htmlspecialchars($_SESSION['user']['username']); ?>!</div>
  <div class="admin-logout">
    <a href="logout.php"><button>Logout</button></a>
  </div>
</div>


<div style="max-width:800px; margin:auto; color:white;">
  <form method="post" style="margin-bottom:30px;">
    <h3>Add New Perfume</h3>
    <input type="text" name="name" placeholder="Perfume Name" required><br>
    <input type="text" name="top_notes" placeholder="Top Notes"><br>
    <input type="text" name="heart_notes" placeholder="Heart Notes"><br>
    <input type="text" name="base_notes" placeholder="Base Notes"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="url" name="image_url" placeholder="Image URL" required><br>
    <button type="submit" name="add">➕ Add Perfume</button>
  </form>

  <h3>Existing Perfumes</h3>
  


  <?php 
  $result = $conn->query("SELECT * FROM perfumes ORDER BY id DESC");

if (!$result) {
    die("Error fetching perfumes: " . $conn->error);
}     
  while ($row = $result->fetch_assoc()): ?>
    <div style="background:rgba(255,255,255,0.1); padding:15px; margin-bottom:15px; border-radius:10px;">
      <img src="<?= htmlspecialchars($row['image_url']) ?>" style="width:150px; border-radius:8px;"><br>
      <strong><?= htmlspecialchars($row['name']) ?></strong><br>
      <small>Top: <?= htmlspecialchars($row['top_notes']) ?><br>
      Heart: <?= htmlspecialchars($row['heart_notes']) ?><br>
      Base: <?= htmlspecialchars($row['base_notes']) ?></small><br>
      <em><?= htmlspecialchars($row['description']) ?></em><br>
      <a href="admin_page.php?delete=<?= $row['id'] ?>" style="color:red;" onclick="return confirm('Delete this perfume?')">🗑 Delete</a>
    </div>
  <?php endwhile; ?>
</div>
