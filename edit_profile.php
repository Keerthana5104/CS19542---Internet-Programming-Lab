<?php
session_start();
include 'db_config.php'; // Database connection

$freelancer_id = $_SESSION['freelancer_id'];
$query = "SELECT * FROM freelancers WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $freelancer_id);
$stmt->execute();
$result = $stmt->get_result();
$freelancer = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];
    $domain = $_POST['domain'];
    $location = $_POST['location'];

    $update_query = "UPDATE freelancers SET name=?, phone_number=?, domain=?, location=? WHERE id=?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $phone_number, $domain, $location, $freelancer_id);
    $update_stmt->execute();

    header("Location: view_profile.php"); // Redirect after update
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Edit Profile</h1>
        <form method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($freelancer['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" value="<?php echo htmlspecialchars($freelancer['phone_number']); ?>" required>
            </div>
            <div class="form-group">
                <label for="domain">Domain:</label>
                <input type="text" class="form-control" name="domain" value="<?php echo htmlspecialchars($freelancer['domain']); ?>" required>
            </div>
            <div class="form-group">
                <label for="location">Location:</label>
                <input type="text" class="form-control" name="location" value="<?php echo htmlspecialchars($freelancer['location']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</body>
</html>
