<?php
include 'db_config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user_type = $_POST['user_type'];

    // Insert the new user into the database
    $sql = "INSERT INTO users (name, email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Registration successful!'); window.location.href = 'login.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h2 class="my-5 text-center">Signup</h2>
        <form method="POST" action="signup.php">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="user_type">I am a</label>
                <select class="form-control" id="user_type" name="user_type">
                    <option value="client">Client</option>
                    <option value="freelancer">Freelancer</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
    </div>
</body>
</html>
