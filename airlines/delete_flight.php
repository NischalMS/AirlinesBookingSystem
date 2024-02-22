<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username from the POST data
    $username = $_POST["username"];
    $tsid = $_POST["tsid"];

    // Create a database connection (include your db_connect.php)
    include 'db_connect.php';

    // Delete the user entry from the users table based on the username
    $sql_user = "DELETE FROM users WHERE username = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $username);

    if (!$stmt_user->execute()) {
        echo '<script>alert("Error occurred while deleting the user: ' . $stmt_user->error . '");</script>';
        exit;
    } else {
        echo '<script>alert("User deleted successfully");</script>';
    }
    $stmt_user->close();

    // Delete the transaction entry from the Transaction table based on the Flight_ID
    $sql_transaction = "DELETE FROM Transaction WHERE Ts_ID = ?";
    $stmt_transaction = $conn->prepare($sql_transaction);
    $stmt_transaction->bind_param("s", $tsid); // Corrected binding here

    if (!$stmt_transaction->execute()) {
        echo '<script>alert("Error occurred while deleting the flight: ' . $stmt_transaction->error . '");</script>';
        exit;
    } else {
        echo '<script>alert("TRANSACTION deleted successfully");</script>';
    }

    $stmt_transaction->close();
    $conn->close();
}
?>
