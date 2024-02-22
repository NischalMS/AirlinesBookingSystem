<!DOCTYPE html>
<html>
<head>
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('home.gif'); /* Replace 'your-background.gif' with the URL of your GIF image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-color: rgba(255, 255, 255, 0.5);
            margin: 0;
            color: #fff;
            text-align: center;
        }

        .top-bar {
            background-color: #283747;
            padding: 10px;
            margin-bottom: 80px; /* Added margin here */
        }

        .top-bar h1 {
            font-size: 24px;
            margin: 0;
            color: #fff;
        }

        h2 {
            font-size: 45px;
            margin: 20px ;
            color: #283747;
            margin-bottom: 40px; /* Added margin here */
        }

        .welcome-box {
            background-color: rgba(255, 255, 255, 0.5);
            border-radius: 10px;
            padding: 20px;
            display: inline-block;
            margin-bottom: 40px; /* Added margin here */
        }

        .welcome-box h2 {
            margin: 0;
        }

        .info-box {
            background-color: rgba(169, 169, 169, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            margin-bottom: 40px; /* Added margin here */
        }

        .info-box p {
            font-size: 18px;
            margin: 0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #00cc99;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
            width: 100px;
        }
        .navbar {
            background-color: #283747;
            overflow: hidden;
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
    </style>
</head>
<body>
<div class="navbar">
        <a href="login.php">Login</a>
        <a href="flight.php">View Flights</a>
        <a href="delete_user.html">Cancel</a>
        <a href="about_us.php">About Us</a>
    </div>
    <div class="top-bar">
        <h1>Airline Booking System</h1>
    </div>

    <div class="welcome-box">
        <h2>Home</h2>
    </div>
<!-- 
    <div class="info-box">
        <p>Explore flights and travel around the world with our Airlines Database Management Project.</p>
    </div> -->

    <!-- <a href="flight.php" class="button">View Flights</a>
    <a href="login.php" class="button">Login</a> -->
</body>
</html>
