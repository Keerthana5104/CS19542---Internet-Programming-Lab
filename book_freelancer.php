<?php
session_start(); // Start the session

// Include database configuration
include 'db_config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve freelancer details from POST request
    $freelancer_name = htmlspecialchars(trim($_POST['freelancer_name']));
    $freelancer_domain = htmlspecialchars(trim($_POST['freelancer_domain']));
    $freelancer_location = htmlspecialchars(trim($_POST['freelancer_location']));

    // Prepare an SQL statement to insert the booking into the database
    $sql = "INSERT INTO bookings(freelancer_name, domain, location) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("sss", $freelancer_name, $freelancer_domain, $freelancer_location);

        // Execute the statement
        if ($stmt->execute()) {
            // Set a success message in the session
            $_SESSION['booking_message'] = "Booking request has been sent to " . htmlspecialchars($freelancer_name) . "!";
        } else {
            // Set an error message in the session
            $_SESSION['booking_message'] = "Error: Could not book the freelancer. Please try again.";
        }
        $stmt->close(); // Close the statement
    } else {
        $_SESSION['booking_message'] = "Error: Could not prepare the booking statement. Please try again.";
    }
} else {
    $_SESSION['booking_message'] = "Invalid request method.";
}

// Redirect back to the client dashboard
header("Location: client-dashboard.php");
exit;
?>
