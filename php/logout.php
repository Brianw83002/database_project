<?php
session_start(); // Start the session

// Destroy the session to log the user out
session_destroy();

// Redirect to home.html
header("Location: ../html/home.html");
exit();
?>
