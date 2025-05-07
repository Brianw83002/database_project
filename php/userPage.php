<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../html/login.html");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Page</title>
  <link rel="stylesheet" href="../css/userPage.css"> <!-- Link to the new CSS -->
</head>
<body>
  <div class="container">
    <h1>Welcome, <?= $username ?>!</h1>
    <p>Select an option below:</p>
    
    <a href="../html/createQuiz.html" class="button">Create a Quiz</a><br>
    <a href="../php/display_quiz.php" class="button">Take a Quiz</a><br>
    
    <form action="logout.php" method="post">
      <button type="submit">Logout</button>
    </form>
  </div>
</body>
</html>
