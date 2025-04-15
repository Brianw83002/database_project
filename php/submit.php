<?php
$host = "localhost";
$user = "root";
$password = "18245Bw!"; // use your MySQL root password if you set one
$database = "quizdb";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted and required fields are present
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if 'username' and 'pword' keys exist in the $_POST array
    if (isset($_POST['username']) && isset($_POST['pword'])) {
        // Get values from the form
        $username = $_POST['username'];
        $pword = $_POST['pword'];

        // Make sure the username and password are not empty
        if (!empty($username) && !empty($pword)) {
            // Check if the username already exists
            $check_sql = "SELECT * FROM users WHERE username = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $username); // 's' means a string parameter
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();

            if ($check_result->num_rows > 0) {
                // Username already exists
                echo "<script>alert('Username already exists. Please choose another one.'); window.location.href='../html/createAccount.html';</script>";
            } else {
                // Prepare SQL query to insert data
                $sql = "INSERT INTO users (username, pword) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $username, $pword); // 'ss' means both are strings

                // Execute the query
                if ($stmt->execute()) {
                    echo "<script>alert('Account created successfully!'); window.location.href='../html/login.html';</script>";
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            }

            // Close the check statement
            $check_stmt->close();
        } else {
            echo "Both username and password are required.";
        }
    } else {
        echo "Username or password not set!";
    }
} else {
    echo "Invalid request method!";
}

// Close the connection
$conn->close();
?>
