<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit;
}

$host = "localhost";
$username = "root";
$password = "";
$database = "testimony";

$conn = new mysqli($host, $username, $password, $database);

if (isset($_GET['activate'])) {
    $id = intval($_GET['activate']);
    $conn->query("UPDATE testimonial SET status='active' WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM testimonial WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}

$result = $conn->query("SELECT * FROM testimonial ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3 class="mb-4">Testimonial Dashboard</h3>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th><th>Name</th><th>Email</th><th>Country</th><th>Topic</th><th>Testimony</th><th>Status</th><th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['country']) ?></td>
          <td><?= htmlspecialchars($row['topic']) ?></td>
          <td><?= nl2br(htmlspecialchars($row['testimony'])) ?></td>
          <td>
            <span class="badge bg-<?= $row['status'] === 'active' ? 'success' : 'secondary' ?>">
              <?= ucfirst($row['status']) ?>
            </span>
          </td>
          <td>
            <?php if ($row['status'] === 'inactive'): ?>
              <a href="?activate=<?= $row['id'] ?>" class="btn btn-sm btn-outline-success">Activate</a>
            <?php endif; ?>
            <a href="edit_testimonial.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
            <a href="?delete=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this testimonial?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>

<?php $conn->close(); ?>