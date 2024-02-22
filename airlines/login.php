<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('plane_login.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5);
            margin: 0;
            color: #333;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .navbar {
            background-color: #283747;
            overflow: hidden;
            position: fixed; /* Set the navbar to fixed position */
            width: 100%; /* Full width */
            top: 0; /* Position it at the top of the page */
        }

        /* Style the navbar links */
        .navbar a {
            float: left;
            font-size: 18px;
            color: #fff;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change the color of navbar links on hover */
        .navbar a:hover {
            background-color: #00cc99;
            color: #fff;
        }

        .login-box {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            opacity: 0.9;
            text-align: left;
        }

        h2 {
            color: #333;
        }

        label, input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 10px;
            display: block;
        }

        input[type="submit"], button {
            width: 100%;
            padding: 15px;
            font-size: 20px;
            background-color: #00cc99;
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            display: inline-block;
            box-sizing: border-box;
        }

        button {
            background-color: #009973;
        }

        button:hover {
            background-color: #006544;
        }
    </style>
</head>
<body>
<div class="navbar">
        <a href="home.php">Home</a>
        <a href="flight.php">View Flights</a>
        <a href="delete_user.html">Delete User</a>
        <a href="about_us.php">About Us</a>
    </div>
    <div class="login-box">
        <h2>Login</h2>
        <form action="process_login.php" method="POST">
            <label for="username">Username</label>
            <input type="text" name="username" required>
            
            <label for="password">Password</label>
            <input type="password" name="password" required>

            
            <input type="submit" value="Login">
            <br></br>
            <a href="registration.html"><button type="button">Register</button></a>
        </form> 
    </div> 
</body> 
</html> 
