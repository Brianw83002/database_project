<?php
//To run in cmd line type 
// "php -S localhost:5500"
// go to http://localhost:5500/connect.php
function getDBConnection($dbname = "quizdb") {
    $servername = "127.0.0.1";
    $username = "root";
    $password = "";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo "Connected";
    return $conn;
}
?>