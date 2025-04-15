<?php
session_start();

// Database connection settings
$servername = "127.0.0.1";
$username = "root";
$password = "18245Bw!";  // your MySQL password
$dbname = "quizdb";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form values
$user = $_POST['username'];
$pass = $_POST['pword'];

// Check credentials in table "people"
$sql = "SELECT * FROM users WHERE username=? AND pword=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    // Successful login
    header("Location: ../html/home.html");
    exit();
} else {
    // Failed login
    echo "<script>
        alert('Incorrect username or password.');
        window.location.href = '../html/login.html';
    </script>";
}

$conn->close();
?>
