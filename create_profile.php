<?php
// Include the database configuration
include 'db_config.php';

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'freelancer') {
    header('Location: login.html');
    exit;
}

// Use the mysqli connection from db_config.php
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $domain = mysqli_real_escape_string($conn, $_POST['domain']);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    
    // Insert into the database
    $sql = "INSERT INTO freelancer (name, email, domain, experience, location) VALUES (?, ?, ?, ?, ?)";
    
    // Prepare the statement
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sssss", $name, $email, $domain, $experience, $location);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Profile created successfully!');</script>";
    } else {
        echo "<script>alert('Failed to create profile: " . mysqli_error($conn) . "');</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Create New Profile</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="domain">Domain</label>
            <input type="text" class="form-control" id="domain" name="domain" required>
        </div>
        <div class="form-group">
            <label for="experience">Experience</label>
            <input type="text" class="form-control" id="experience" name="experience" required>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" required>
        </div>
        <button type="submit" class="btn btn-primary">Create Profile</button>
    </form>
</div>
</body>
</html>
