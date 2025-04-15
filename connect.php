<?php
//To run in cmd type go to the folder where these files are located and enter: 
// "php -S localhost:5500"
// go to http://localhost:5500/connect.php

//CHANGE THESE TO CHECK CONNECTION
$username = "root";         // MySQL username
$password = "";             // MySQL password
$dbname = "users";          // The database you want to connect to (e.g., "users")

$servername = "127.0.0.1";  // or "localhost"
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to MySQL!";
?>