<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $age = $_POST["age"];
    $house_no = $_POST["house_no"];
    $street = $_POST["street"];
    $city = $_POST["city"];
    $sex = $_POST["sex"];
    $phone = $_POST["phone"];

    // Create a database connection
    include('db_connect.php');
    
    // Insert passenger data into the 'passengers' table
    $sql_passenger = "INSERT INTO passengers(P_fname, P_lname, Age, House_no, Street, City, Sex) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_passenger = $conn->prepare($sql_passenger);

    if (!$stmt_passenger) {
        echo '<script>alert("Error occurred while preparing the passenger insertion statement: ' . $conn->error . '");</script>';
        exit;
    }

    $stmt_passenger->bind_param("ssissss", $first_name, $last_name, $age, $house_no, $street, $city, $sex);

    if (!$stmt_passenger->execute()) {
        echo '<script>alert("Error occurred during passenger insertion: ' . $stmt_passenger->error . '");</script>';
        exit;
    }

    // Passenger registration successful
    $passenger_id = $stmt_passenger->insert_id;
    $stmt_passenger->close();

    //Insert user data into the user table
    $sql_user = "INSERT INTO users(username, password) VALUES (?, ?)";
    $stmt_user = $conn->prepare($sql_user);

    if (!$stmt_user) {
        echo '<script>alert("Error occurred while preparing the user insertion statement: ' . $conn->error . '");</script>';
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt_user->bind_param("ss", $username, $hashed_password);

    if (!$stmt_user->execute()) {
        echo '<script>alert("Error occurred during user registration: ' . $stmt_user->error . '");</script>';
        exit;
    }

    // User registration successful
    $stmt_user->close();

    // Insert phone data into the 'passenger_contact' table
    $sql_contact = "INSERT INTO passenger_contact(P_ID, Contact) VALUES (?, ?)";
    $stmt_contact = $conn->prepare($sql_contact);

    if (!$stmt_contact) {
        echo '<script>alert("Error occurred while preparing the contact insertion statement: ' . $conn->error . '");</script>';
        exit;
    }

    $stmt_contact->bind_param("is", $passenger_id, $phone);

    if (!$stmt_contact->execute()) {
        echo '<script>alert("Error occurred during phone insertion: ' . $stmt_contact->error . '");</script>';
        exit;
    }

    // Phone number insertion successful
    echo '<script>
    alert("Registration successful");
    window.location.href = "login.php"; // Redirect to login.php
</script>';

    $stmt_contact->close();
    $conn->close();
}
?> 
