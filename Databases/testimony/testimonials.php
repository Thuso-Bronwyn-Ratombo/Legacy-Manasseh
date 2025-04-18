<?php
$conn = new mysqli("localhost", "root", "", "testimony");
$result = $conn->query("SELECT * FROM testimonial WHERE status='active' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Testimonials</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4">What Our Clients Say</h3>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="card mb-3 shadow-sm">
      <div class="card-body">
        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?> (<?= htmlspecialchars($row['country']) ?>)</h5>
        <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($row['topic']) ?></h6>
        <p class="card-text"><?= nl2br(htmlspecialchars($row['testimony'])) ?></p>
      </div>
    </div>
  <?php endwhile; ?>
</div>
</body>
</html>