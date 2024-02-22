<?php
$charged_amount = 0;
$passenger_id = ""; // Initialize passenger_id to an empty string
$flight_id = "";

if (isset($_POST['flight_id'])) {
    // You'll need to replace this with your database connection logic
    include 'db_connect.php';

    $flight_id = $_POST['flight_id'];
   

    // Fetch charged amount from the Airfare table based on flight ID and passenger ID
    $sql_airfare = "SELECT Charged_amount FROM Airfare WHERE Flight_ID = ?";
    if ($stmt_airfare = $conn->prepare($sql_airfare)) {
        $stmt_airfare->bind_param("i", $flight_id);
        $stmt_airfare->execute();
        $stmt_airfare->bind_result($charged_amount);
        $stmt_airfare->fetch();
        $stmt_airfare->close();
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
<head>
    <title>Payment Gateway</title>
    <style>
        body {
            background-image: url('picture_transaction.jpeg');
            background-size: cover;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5); /* 50% transparency */
            color: #ffffff; /* Light text color */
            font-family: Arial, sans-serif; /* Specify desired font */
        }

        h2 {
            text-align: center;
            font-size: 48px;
            color: #ffffff;
        }

        .transaction-details {
            max-width: 600px;
            margin: 0 auto;
            background-color: rgba(169, 169, 169, 0.85); /* 50% transparency and grey */
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 10px;
        }

        select, input[type="text"] {
            width: 95%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .confirm-button {
            background-color: #4caf50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        .confirm-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h2>Payment Gateway</h2>

    <div class="transaction-details">
        <form action="process_transaction.php" method="POST">
            <!-- Transaction Type Dropdown -->
            <label for="transaction_type">Transaction Type:</label>
            <select name="transaction_type" required>
                <option value="GooglePay">GooglePay</option>
                <option value="PhonePe">PhonePe</option>
                <option value="Credit Card">Credit Card</option>
                <option value="Debit Card">Debit Card</option>
                <option value="Paytm">Paytm</option>
                <!-- Add more transaction types as needed // -->
            </select><br>
        <label for="charged_amount">Charged Amount:</label>
        <input type="text" name="charged_amount" value="<?php echo $charged_amount;?>"required readonly ><br><br>

        <label for="flight_id">Flight ID:</label>
        <input type="text" name="flight_id" value="<?php echo $flight_id; ?>"required readonly ><br><br>

        <input type="submit" value="Add Transaction">
    </form>
    <br>
    <a href="home.php">Back to Home</a>
</body>
</html>
