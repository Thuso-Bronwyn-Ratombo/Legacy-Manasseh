<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "testimony";

$conn = new mysqli($host, $username, $password, $database);

// Hash the password before saving
$hashedPassword = password_hash('password123', PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (username, password) VALUES ('admin@gmail.com', '$hashedPassword')";
$conn->query($sql);

echo "Admin user created!";
?>
