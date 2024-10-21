<?php
session_start();
include 'db_config.php'; // Database configuration file

// Check if the user is logged in and is a freelancer
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'freelancer') {
    header('Location: login.php');
    exit();
}

// Get the freelancer's name from the session
$freelancer_name = $_SESSION['user_name']; // Assuming 'user_name' is the freelancer's name

// Prepare the SQL statement to fetch bookings for the logged-in freelancer
$sql = "SELECT * FROM bookings WHERE freelancer_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $freelancer_name); // Bind the freelancer's name to the query
$stmt->execute();
$result = $stmt->get_result(); // Fetch result from query execution
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="my-5 text-center">My Bookings</h2>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Freelancer Name</th>
                        <th>Domain</th>
                        <th>Location</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['freelancer_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['domain']); ?></td>
                            <td><?php echo htmlspecialchars($row['location']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                            <td>
                                <a href="update_booking.php?id=<?php echo $row['id']; ?>&action=accept" class="btn btn-success">Accept</a>
                                <a href="update_booking.php?id=<?php echo $row['id']; ?>&action=reject" class="btn btn-danger">Reject</a>
                            </td>
