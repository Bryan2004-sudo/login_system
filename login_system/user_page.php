<?php
session_start();
include 'config.php';
$perfumes = $conn->query("SELECT * FROM perfumes ORDER BY id DESC");

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'user') {
    header('Location: login.php');
    exit;
}
$user = $_SESSION['user'];
?>

<link rel="stylesheet" href="style.css">

<!-- Top Bar -->
<div class="top-bar">
  <div class="welcome">👋 Welcome, <?php echo htmlspecialchars($user['username']); ?>!</div>
  <div class="logout"><a href="logout.php"><button>Logout</button></a></div>
</div>

<!-- Scrollable Perfume Cards -->
<div class="scroll-container">
  <?php while ($row = $perfumes->fetch_assoc()): ?>
    <div class="perfume-card">
      <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
      <h3><?= htmlspecialchars($row['name']) ?></h3>
      <p><strong>Top:</strong> <?= htmlspecialchars($row['top_notes']) ?></p>
      <p><strong>Heart:</strong> <?= htmlspecialchars($row['heart_notes']) ?></p>
      <p><strong>Base:</strong> <?= htmlspecialchars($row['base_notes']) ?></p>
      <p class="desc"><?= htmlspecialchars($row['description']) ?></p>
    </div>
  <?php endwhile; ?>
</div>


</div>
