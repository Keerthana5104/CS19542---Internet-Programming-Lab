<?php
session_start();
include 'db_connection.php'; // Database connection

// Initialize search query
$search_query = '';

// Check if the form has been submitted
if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];
}

// Prepare the SQL statement
$query = "SELECT * FROM freelancers WHERE name LIKE ? OR domain LIKE ? OR location LIKE ?";
$stmt = $conn->prepare($query);
$search_term = "%" . $search_query . "%";
$stmt->bind_param("sss", $search_term, $search_term, $search_term);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Freelancers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>Available Freelancers</h1>

        <!-- Search Form -->
        <form method="post" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search_query" placeholder="Search by name, domain, or location" value="<?php echo htmlspecialchars($search_query); ?>">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($freelancer = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($freelancer['name']); ?></h5>
                                <p class="card-text">Domain: <?php echo htmlspecialchars($freelancer['domain']); ?></p>
                                <p class="card-text">Location: <?php echo htmlspecialchars($freelancer['location']); ?></p>
                                <p class="card-text">Phone: <?php echo htmlspecialchars($freelancer['phone_number']); ?></p>
                                <a href="bookings.php?id=<?php echo $freelancer['id']; ?>" class="btn btn-primary">Book Now</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>No freelancers found matching your search criteria.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
