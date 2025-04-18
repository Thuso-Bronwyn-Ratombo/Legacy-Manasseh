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

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM testimonial WHERE id=$id");
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $country = $_POST['country'];
    $topic = $_POST['topic'];
    $testimony = $_POST['testimony'];

    $stmt = $conn->prepare("UPDATE testimonial SET name=?, email=?, country=?, topic=?, testimony=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $email, $country, $topic, $testimony, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Testimonial</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h4>Edit Testimonial</h4>
  <form method="POST">
    <div class="mb-3"><label>Name</label><input class="form-control" name="name" value="<?= $data['name'] ?>"></div>
    <div class="mb-3"><label>Email</label><input class="form-control" name="email" value="<?= $data['email'] ?>"></div>
    <div class="mb-3"><label>Country</label><input class="form-control" name="country" value="<?= $data['country'] ?>"></div>
    <div class="mb-3"><label>Topic</label><input class="form-control" name="topic" value="<?= $data['topic'] ?>"></div>
    <div class="mb-3"><label>Testimony</label><textarea class="form-control" name="testimony"><?= $data['testimony'] ?></textarea></div>
    <button class="btn btn-primary">Update</button>
    <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>
</body>
</html>