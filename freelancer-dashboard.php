<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'freelancer') {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freelancer Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .card {
            height: 200px; /* Set a fixed height for all cards */
            display: flex; /* Use flexbox to align content */
            flex-direction: column; /* Stack elements vertically */
            justify-content: center; /* Center content vertically */
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center mb-4">Welcome, Freelancer!</h1>

    <div class="row">
        <!-- View Bookings Card -->
        <div class="card text-center col-md-12 mb-8">
            <div class="card-body ">
                <h5 class="card-title mb-0">View my Profile</h5>
                <a href="bookings.php" class="btn btn-primary">View Profile</a>
                <br>
                <h6 class="mt-2"> <a href="create_profile.php">Create new profile</a></h6>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- View Bookings Card -->
        <div class="card text-center col-md-12 mb-8">
            <div class="card-body ">
                <h5 class="card-title mb-0">View my Bookings</h5>
                <a href="bookings.php" class="btn btn-secondary">View Bookings</a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- View Bookings Card -->
        <div class="card text-center col-md-12 mb-8">
            <div class="card-body ">
                <h5 class="card-title mb-0">Logout</h5>
                <a href="index.html" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>



</div>

</body>
</html>


