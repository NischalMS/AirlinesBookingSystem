<?php
// Start a session (if not already started)
session_start();

// Check if the user is authenticated, and if so, display a link to the reservation page
if ($_SESSION['authenticated']) {
    // Assuming you have stored user data in the session during login
    $first_name = $_SESSION['first_name'];

    // Fetch flight ID from the reservation data (replace with your logic)
    $flight_id = $_SESSION['flight_id'];

    // Connect to your database
    include 'db_connect.php';

    // Fetch the "Class Options" and "Charged Amount" based on the selected flight and seat class
    if (isset($_POST['departure']) && isset($_POST['arrival']) && isset($_POST['seat_class'])) {
        $departure = $_POST['departure'];
        $arrival = $_POST['arrival'];
        $seat_class = $_POST['seat_class'];

        // Add the new transaction data to the database (customize this part as needed)
        $transaction_type = $_POST['transaction_type'];
        $departure_date = $_POST['departure_date'];
        $booking_date = $_POST['booking_date'];

        // Insert this transaction into your transactions table with a nested SELECT
        $insert_sql = "
            INSERT INTO Transactions (Transaction_Type, Departure_Date, Booking_Date, Charged_Amount, Passenger_Name, Flight_ID)
            VALUES (?, ?, ?, (SELECT Charged_Amount FROM Airfare WHERE Flight_ID = ? AND Seat_Class = ?), ?, ?)
        ";

        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param('ssssss', $transaction_type, $departure_date, $booking_date, $flight_id, $seat_class, $first_name, $flight_id);
        $insert_stmt->execute();
        $insert_stmt->close();

        // Redirect to a success page or perform other actions
        header('Location: flight.php');
        exit();
    } else {
        // Handle missing POST data
        echo "Missing required data.";
    }

    // Close the database connection
    $conn->close();
} else {
    // User is not authenticated, redirect to login page
    header('Location: login.php');
    exit();
}
?> 
