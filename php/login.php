<?php
session_start();

require_once 'connect.php'; // ✅ Include the connection function
$conn = getDBConnection("quizdb"); // Pass your target DB name

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
    // ✅ Successful login — store username in session
    $_SESSION['username'] = $user;
    header("Location: ../php/userPage.php"); // 🔁 redirect to a PHP file instead of HTML
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
