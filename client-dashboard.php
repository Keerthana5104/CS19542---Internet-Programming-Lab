<?php
session_start(); // Start the session

// Include database configuration
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1 class="my-5">Welcome, Client!</h1>
        <p>Search for freelancers:</p>
        <form id="search-form" method="GET" action="">
            <div class="form-group">
                <label for="job_domain">Freelancer Category</label>
                <select class="form-control" id="job_domain" name="job_domain">
                <option value="">Select Category</option>
                    <option value="designer">Designer</option>
                    <option value="web_developer">Web Developer</option>
                    <option value="actor">Actor</option>
                    <option value="photographer">Photographer</option>
                    <option value="content_writer">Content Writer</option>
                    <option value="graphic_designer">Graphic Designer</option>
                    <option value="seo_specialist">SEO Specialist</option>
                    <option value="social_media_manager">Social Media Manager</option>
                    <option value="mobile_app_developer">Mobile App Developer</option>
                    <option value="video_editor">Video Editor</option>
                    <option value="virtual_assistant">Virtual Assistant</option>
                    <option value="translator">Translator</option>
                    <option value="voice_actor">Voice Actor</option>
                    <option value="illustrator">Illustrator</option>
                    <option value="animator">Animator</option>
                    <option value="data_analyst">Data Analyst</option>
                    <option value="ux_ui_designer">UX/UI Designer</option>
                    <option value="frontend_developer">Frontend Developer</option>
                    <option value="backend_developer">Backend Developer</option>
                    <option value="full_stack_developer">Full Stack Developer</option>
                    <option value="email_marketing_specialist">Email Marketing Specialist</option>
                    <option value="copywriter">Copywriter</option>
                    <option value="legal_consultant">Legal Consultant</option>
                    <option value="financial_advisor">Financial Advisor</option>
                    <option value="marketing_consultant">Marketing Consultant</option>
                    <option value="software_engineer">Software Engineer</option>
                    <option value="product_manager">Product Manager</option>
                    <option value="project_manager">Project Manager</option>
                    <option value="sales_consultant">Sales Consultant</option>
                    <option value="customer_support_specialist">Customer Support Specialist</option>
                    <option value="event_planner">Event Planner</option>
                    <option value="interior_designer">Interior Designer</option>
                    <option value="architect">Architect</option>
                    <option value="public_relations_specialist">Public Relations Specialist</option>
                    <option value="blogger">Blogger</option>
                    <option value="youtuber">YouTuber</option>
                    <option value="fitness_trainer">Fitness Trainer</option>
                    <option value="nutritionist">Nutritionist</option>
                    <option value="personal_coach">Personal Coach</option>
                    <option value="psychologist">Psychologist</option>
                </select>
            </div>

            <div class="form-group">
                <label for="location">Select City</label>
                <select class="form-control" id="location" name="location">
                <option value="">Select City</option>
                    <option value="mumbai">Mumbai</option>
                    <option value="delhi">Delhi</option>
                    <option value="bengaluru">Bengaluru</option>
                    <option value="kolkata">Kolkata</option>
                    <option value="chennai">Chennai</option>
                    <option value="hyderabad">Hyderabad</option>
                    <option value="pune">Pune</option>
                    <option value="ahmedabad">Ahmedabad</option>
                    <option value="jaipur">Jaipur</option>
                    <option value="lucknow">Lucknow</option>
                    <option value="kanpur">Kanpur</option>
                    <option value="nagpur">Nagpur</option>
                    <option value="patna">Patna</option>
                    <option value="indore">Indore</option>
                    <option value="bhopal">Bhopal</option>
                    <option value="vadodara">Vadodara</option>
                    <option value="coimbatore">Coimbatore</option>
                    <option value="ludhiana">Ludhiana</option>
                    <option value="agra">Agra</option>
                    <option value="varanasi">Varanasi</option>
                </select>
            </div>

            <button type="submit" class="btn btn-info">Search Freelancers</button>
        </form>

        <div id="freelancer-results"></div>

        <?php
        if (isset($_SESSION['booking_message'])) {
            echo '<div class="alert alert-success mt-5">' . htmlspecialchars($_SESSION['booking_message']) . '</div>';
            unset($_SESSION['booking_message']);
        }

        if (isset($_GET['job_domain']) && isset($_GET['location'])) {
            $job_domain = htmlspecialchars($_GET['job_domain']);
            $location = htmlspecialchars($_GET['location']);

            if (!empty($job_domain) && !empty($location)) {
                $sql = "SELECT name, domain, location FROM freelancer WHERE domain LIKE ? AND location = ?";
                $stmt = $conn->prepare($sql);
                $like_job_domain = "%" . $job_domain . "%";
                $stmt->bind_param("ss", $like_job_domain, $location);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo '<h2 class="my-5">Available Freelancers</h2>';
                    echo '<table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Domain</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>
                                <td>' . htmlspecialchars($row['name']) . '</td>
                                <td>' . htmlspecialchars($row['domain']) . '</td>
                                <td>' . htmlspecialchars($row['location']) . '</td>
                                <td>
                                    <form method="POST" action="book_freelancer.php">
                                        <input type="hidden" name="freelancer_name" value="' . htmlspecialchars($row['name']) . '">
                                        <input type="hidden" name="freelancer_domain" value="' . htmlspecialchars($row['domain']) . '">
                                        <input type="hidden" name="freelancer_location" value="' . htmlspecialchars($row['location']) . '">
                                        <button type="submit" class="btn btn-success">Book</button>
                                    </form>
                                </td>
                              </tr>';
                    }

                    echo '</tbody></table>';
                } else {
                    echo '<div class="alert alert-warning mt-5">No freelancers available for the selected category and location.</div>';
                }
                $stmt->close();
            } else {
                echo '<div class="alert alert-danger mt-5">Please select both a category and a city.</div>';
            }
        }

        mysqli_close($conn);
        ?>

        <a href="index.html" id="logoutBtn" class="btn btn-danger mt-3">Logout</a>
    </div>

    <script>
        document.getElementById("logoutBtn").addEventListener("click", function(event) {
            event.preventDefault(); // prevent the default link action
            window.location.href = "index.html"; // Assuming logout.php handles session destruction
        });
    </script>
    <style>
   .form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
    </style>
</body>
</html>
