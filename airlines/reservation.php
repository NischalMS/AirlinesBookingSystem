
<!DOCTYPE html>
<html>
<head>
    <title>Reservation Page</title>
    <style>
        body {
            background-image: url('plane_reservation.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5); /* 50% transparency */
        }

        h2 {
            font-size: 48px;
            color: #ffffff;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            background-color: rgba(169,169,169,0.5);
            padding: 20px;
            border-radius: 10px;
        }

        label, select, input[type="date"] {
            display: block;
            margin-bottom: 10px;
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
        }

        select, input[type="date"] {
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: calc(100% - 20px);
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        a : hover{
            display: block;
            background-color: #4caf50;
            text-align: center;
            margin-top: 10px;
            color: #ffffff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Flight Reservation</h2>
    
    <form action="flight_search.php" method="POST">
    <label for="departure">Departure:</label>
    <select name="departure" required>
        <?php
        // Connect to the database (You can include your db_connect.php here)
        include 'db_connect.php';
        
        // Fetch unique departure locations from the Route table
        $sql = "SELECT DISTINCT Departure FROM Route";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['Departure']}'>{$row['Departure']}</option>";
            }
        }
        ?>
    </select><br><br>
    
    <label for="arrival">Arrival:</label>
    <select name="arrival" required>
        <?php
        // Fetch unique arrival locations from the Route table
        $sql = "SELECT DISTINCT Destination FROM Route";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['Destination']}'>{$row['Destination']}</option>";
            }
        }
        ?>
    </select><br><br>
    
    <label for="date">Date:</label>
    <input type="date" name="date" required>
    
    <input type="submit" value="Search Flights">
    <a href="delete_flight.html">Cancel</a>
</form>


    
    <?php
    // Close the database connection (You can include your db_connect.php here)
    $conn->close();
    ?>
</body>
</html>
