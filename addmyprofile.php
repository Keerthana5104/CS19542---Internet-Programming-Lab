<?php
session_start();
include 'db_connection.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $domain = $_POST['domain'];
    $location = $_POST['location'];

    $insert_query = "INSERT INTO freelancers (name, phone_number, domain, location) VALUES (?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_query);
    $insert_stmt->bind_param("ssss", $name, $phone_number, $domain, $location);
    $insert_stmt->execute();

    header("Location: view_profile.php"); // Redirect after insertion
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add My Profile</title>
    <link rel="stylesheet" href="path_to_bootstrap.css"> <!-- Add your Bootstrap link -->
</head>
<body>
    <div class="container">
        <h1>Add My Profile</h1>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" required>
            </div>
            <div class="form-group">
                <label for="domain">Domain:</label>
                <input type="text" class="form-control" name="domain" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" name="location" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Profile</button>
        </form>
    </div>
</body>
</html>
