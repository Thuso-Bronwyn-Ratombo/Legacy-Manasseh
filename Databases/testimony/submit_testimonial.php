<?php
// Direct database connection
$host = "localhost";         // Replace with your DB host
$username = "root";          // Replace with your DB username
$password = "";              // Replace with your DB password
$database = "testimony"; // Replace with your DB name

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("<div style='padding:20px; background:#f8d7da; color:#721c24;'>❌ Database connection failed: " . $conn->connect_error . "</div>");
}

// Sanitize and validate input
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$country = trim($_POST['country']);
$topic = trim($_POST['topic']);
$testimony = trim($_POST['testimony']);

// Basic validation
if (empty($name) || empty($email) || empty($testimony)) {
    echo "<div style='padding:20px; background:#f8d7da; color:#721c24;'>Please fill in all required fields.</div>";
    exit;
}

// Prepare and execute insert statement
$sql = "INSERT INTO testimonial (name, email, country, topic, testimony, status)
        VALUES (?, ?, ?, ?, ?, 'inactive')";

$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sssss", $name, $email, $country, $topic, $testimony);

    if ($stmt->execute()) {
        echo "<div style='padding:20px; background:#d4edda; color:#155724;'>✅ Thank you! Your testimonial has been submitted for review.</div>";
    } else {
        echo "<div style='padding:20px; background:#f8d7da; color:#721c24;'>❌ Error submitting testimonial. Please try again later.</div>";
    }

    $stmt->close();
} else {
    echo "<div style='padding:20px; background:#f8d7da; color:#721c24;'>❌ Failed to prepare SQL statement.</div>";
}

$conn->close();
?>
