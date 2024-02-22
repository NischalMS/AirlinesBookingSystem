<?php
session_start(); // Start the session if not already started

// Function to perform an aggregate query for the total charged amount
function getTotalChargedAmount($flightId, $conn) {
    $aggregateSql = "SELECT SUM(Charged_amount) AS total_charged_amount FROM Transaction WHERE Flight_ID = ?";
    $aggregateStmt = $conn->prepare($aggregateSql);

    if ($aggregateStmt) {
        $aggregateStmt->bind_param("s", $flightId);
        $aggregateStmt->execute();
        $aggregateStmt->bind_result($totalChargedAmount);
        $aggregateStmt->fetch();
        $aggregateStmt->close();

        return $totalChargedAmount;
    } else {
        return false;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required POST parameters are set
    if (
        isset($_POST["transaction_type"]) &&
        isset($_POST["charged_amount"]) &&
        isset($_POST["flight_id"])
    ) {
        // Get the payment method, charged amount, and flight ID from the form
        $paymentMethod = $_POST["transaction_type"];
        $chargedAmount = $_POST["charged_amount"];
        $flightId = $_POST["flight_id"];

        // Create a database connection (include your db_connect.php)
        include 'db_connect.php';

        // Query the Flight table to retrieve the departure date (flight_date) for the selected flight
        $sqlFlight = "SELECT flight_date FROM Flight WHERE Flight_ID = ?";
        $stmtFlight = $conn->prepare($sqlFlight);

        if ($stmtFlight) {
            $stmtFlight->bind_param("s", $flightId);
            $stmtFlight->execute();
            $stmtFlight->bind_result($departureDate); // Use departureDate as the variable to store flight_date
            $stmtFlight->fetch();
            $stmtFlight->close();

            // Insert the transaction details into the Transaction table with the retrieved departure date
            $sqlTransaction = "INSERT INTO Transaction (Ts_type, Departure_date, Booking_date, Charged_amount, Flight_ID)
                    VALUES (?, ?, NOW(), ?, ?)";
            $stmtTransaction = $conn->prepare($sqlTransaction);

            if ($stmtTransaction) {
                // Bind the parameters and execute the query
                $stmtTransaction->bind_param("ssds", $paymentMethod, $departureDate, $chargedAmount, $flightId);

                if ($stmtTransaction->execute()) {
                    // Call the function to get the total charged amount for the specific flight
                    $totalChargedAmount = getTotalChargedAmount($flightId, $conn);

                    if ($totalChargedAmount !== false) {
                        // Display a success alert with the total charged amount
                        echo '<script>alert("Payment successful. Thank you for booking your flight!\nTotal Charged Amount: ' . $totalChargedAmount . '"); window.location.href = "home.php"; </script>';
                    } else {
                        echo '<script>alert("Error in calculating the total charged amount.");</script>';
                    }
                } else {
                    // Display a failure alert
                    echo '<script>alert("Payment failed. Please try again later.");</script>';
                }

                // Close the prepared statement
                $stmtTransaction->close();
            } else {
                echo '<script>alert("Error in preparing the SQL statement for Transaction.");</script>';
            }
        } else {
            echo '<script>alert("Error in preparing the SQL statement for Flight.");</script>';
        }

        // Close the database connection
        $conn->close();
    } else {
        echo '<script>alert("Incomplete POST data. Please fill out the form completely.");</script>';
    }
} else {
    echo '<script>alert("Invalid request. Please submit the form.");</script>';
}
?> 
