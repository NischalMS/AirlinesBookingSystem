<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the required POST parameters are set
    if (
        isset($_POST["flight_id"]) &&
        isset($_POST["new_departure"]) &&
        isset($_POST["new_arrival"]) &&
        isset($_POST["new_date"])
    ) {
        // Get the flight details from the form
        $flight_id = $_POST["flight_id"];
        $new_departure = $_POST["new_departure"];
        $new_arrival = $_POST["new_arrival"];
        $new_date = $_POST["new_date"];

        // Create a database connection (include your db_connect.php)
        include 'db_connect.php';

        // Update the Flight table with the new values
        $update_sql = "UPDATE Flight SET Departure=?, Arrival=?, Flight_date=? WHERE Flight_ID=?";
        $update_stmt = $conn->prepare($update_sql);

        if ($update_stmt) {
            $update_stmt->bind_param('sssi', $new_departure, $new_arrival, $new_date, $flight_id);

            if ($update_stmt->execute()) {
                // Display a success alert with the updated details
                echo '<script>alert("Flight updated successfully!\nUpdated Details:\nFlight ID: ' . $flight_id . '\nDeparture: ' . $new_departure . '\nArrival: ' . $new_arrival . '\nDate: ' . $new_date . '"); window.location.href = "flight.php"; </script>';
            } else {
                // Display a failure alert
                echo '<script>alert("Error updating flight details. Please try again later.");</script>';
            }

            $update_stmt->close();
        } else {
            echo '<script>alert("Error in preparing the SQL statement for updating flight details.");</script>';
        }

        // Close the database connection
        $conn->close();
    } else {
        echo '<script>alert("Incomplete POST data. Please fill out the form completely.");</script>';
    }
} else {
    echo '<script>alert("Invalid request. Please submit the form.");</script>';
}

// SQL code for creating the trigger
$triggerSql = "
    DELIMITER //
    CREATE TRIGGER after_flight_update
    AFTER UPDATE ON Flight
    FOR EACH ROW
    BEGIN
        -- Update the Flight table with the new values
        UPDATE Flight
        SET Departure = NEW.Departure,
            Arrival = NEW.Arrival,
            Flight_date = NEW.Flight_date
        WHERE Flight_ID = NEW.Flight_ID;
    END;
    //
    DELIMITER ;
";
// Execute the SQL code
if ($conn->multi_query($triggerSql)) {
    echo "Trigger created successfully.";
} else {
    echo "Error creating trigger: " . $conn->error;
}
?> 
<?php echo "updated" ?>
