<?php
session_start(); // Start the session
include 'db_config.php'; // Include your database configuration file

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT freelancer_name FROM freelancers WHERE username = ? AND password = ?"); // Ensure to hash and verify passwords in production
    $stmt->bind_param("ss", $username, $password); // Use proper password hashing and verification

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a freelancer was found
    if ($result->num_rows > 0) {
        // Fetch the freelancer's details
        $row = $result->fetch_assoc();
        $freelancer_name = $row['freelancer_name'];

        // Set the freelancer name in the session
        $_SESSION['freelancer_name'] = $freelancer_name;

        // Redirect to the freelancer dashboard or bookings page
        header("Location: freelancer_dashboard.php"); // Change to your dashboard or desired page
        exit();
    } else {
        // Invalid credentials, redirect back to login with an error message
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: login.php"); // Redirect back to login
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect to login if accessed directly
    header("Location: login.php");
    exit();
}
