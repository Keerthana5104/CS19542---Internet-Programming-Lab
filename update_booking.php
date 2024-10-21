<?php
session_start();
include 'db_config.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $booking_id = htmlspecialchars(trim($_GET['id']));
    $action = htmlspecialchars(trim($_GET['action']));

    $sql = "";
    if ($action == "accept") {
        $sql = "UPDATE bookings SET status = 'Accepted' WHERE id = ?";
    } elseif ($action == "reject") {
        $sql = "UPDATE bookings SET status = 'Rejected' WHERE id = ?";
    }

    if (!empty($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $booking_id);

        if ($stmt->execute()) {
            $_SESSION['status_message'] = "Booking status updated successfully.";
        } else {
            $_SESSION['status_message'] = "Error: Could not update booking status.";
        }

        $stmt->close();
    }
}

header('Location: bookings.php');
exit();
?>
