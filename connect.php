<?php
// Run this with: php -S localhost:8000
// Visit: http://localhost:8000/connect.php

$servername = "127.0.0.1";
$username = "root";
$password = "18245Bw!";  // Your MySQL password
$dbname = "quizdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully to MySQL database 'quizdb'<br>";

// Try selecting from the 'users' table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result === false) {
    echo "❌ Could not query 'users' table: " . $conn->error;
} elseif ($result->num_rows > 0) {
    echo "✅ Data from 'users' table:<br>";
    while ($row = $result->fetch_assoc()) {
        echo "Username: " . $row["username"] . " | Password: " . $row["pword"] . "<br>";
    }
} else {
    echo "ℹ️ 'users' table exists but is empty.";
}

$conn->close();
?>
