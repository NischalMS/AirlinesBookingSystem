<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Create a database connection
    include 'db_connect.php';

    // Prepare and execute the SQL statement to retrieve the user's hashed password
    $sql = "SELECT username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $db_password);
    $stmt->fetch();

    if (password_verify($password, $db_password)) {
        // Password is correct
        // Redirect to the reservation.php page
        header("Location: reservation.php");
        exit(); // Make sure to exit after the redirect
    } else {
        // Invalid username or password
        echo '<script>alert("Invalid username or password");</script>';
    }

    $stmt->close();
    $conn->close();
}
?> 
