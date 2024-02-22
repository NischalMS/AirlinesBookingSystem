<!DOCTYPE html>
<html>
<head>
    <title>Available Flights</title>
    <style>
        body {
            background-image: url('flight_search.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5); /* 50% transparency */
            color: #ffffff; /* Light text color */
        }

        h1 {
            text-align: center;
            font-size: 48px;
            color: #ffffff;
        }

        .flight-details {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(100, 100, 100, 0.85); /* Darker grey, 50% transparency */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .flight-details p {
            font-size: 18px;
            margin: 10px 0;
        }

        .select-button {
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .select-button:hover {
            background-color: #45a049;
        }

        a {
            color: #ffffff; /* White text for links */
            text-decoration: underline; /* Underline for links */
            display: block; /* Centering link */
            text-align: center; /* Centering link */
            margin-top: 20px;
        }

        .back-link-container {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            margin-top: 20px auto;
        }

        .flight-class {
            color: #ffcc00; /* Custom color for flight class */
        }
        .no-flights{
            text-align: center;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <h1>Available Flights</h1>
    
    <?php
    // Connect to the database (You can include your db_connect.php here)
    include 'db_connect.php';

    // Retrieve user input
    $departure = $_POST['departure'];
    $arrival = $_POST['arrival'];
    $date = $_POST['date'];

    // Query the database for available flights
    $sql = "SELECT Flight.Flight_ID, Flight.Departure, Flight.Arrival, Flight.Flight_date, Airfare.Class, Airfare.Charged_amount
            FROM Flight
            LEFT JOIN Airfare ON Flight.Flight_ID = Airfare.Flight_ID
            WHERE Departure = ? AND Arrival = ? AND Flight_date = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $departure, $arrival, $date);
    $stmt->execute();
    $stmt->bind_result($flight_id, $departure, $arrival, $flight_date, $class, $charged_amount);

    // Check if there are available flights
    $flightsAvailable = false;

    // Display the list of available flights
    while ($stmt->fetch()) {
        $flightsAvailable = true; // Set to true if there are available flights
        echo "<div class='flight-details'>";
        echo "<p>Flight ID: $flight_id</p>";
        echo "<p>Departure: $departure</p>";
        echo "<p>Arrival: $arrival</p>";
        echo "<p>Date: $flight_date</p>";
        echo "<p class='flight-class'>Class: $class</p>";
        echo "<p>Charged Amount: $charged_amount</p>";
        echo "<form action='transaction.php' method='POST'>";
        echo "<input type='hidden' name='flight_id' value='$flight_id'>";
        echo "<input type='hidden' name='departure' value='$departure'>";
        echo "<input type='hidden' name 'arrival' value='$arrival'>";
        echo "<input type='hidden' name='date' value='$flight_date'>";
        echo "<input type='hidden' name='class' value='$class'>";
        echo "<input type='hidden' name='charged_amount' value='$charged_amount'>";
        echo "<input type='submit' class='select-button' name='select' value='Select'>";
        echo "</form>";
        echo "</div><br>";
    }

    if (!$flightsAvailable) {
        echo "<p class='no-flights'>No available flights for the selected criteria.</p>";
    }

    // Optionally, provide a link to go back to the reservation page
    echo '<div class="back-link-container"><a href="reservation.php">Back to Reservation Page</a></div>';

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
