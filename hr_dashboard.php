<?php
session_start();

// Debug the session to check if the role is correctly stored
// var_dump($_SESSION); die;

// Ensure the user has the 'hr' role to access this page
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'hr') {
    // Redirect to login if the user is not HR or role is not set
    header('Location: login.php');
    exit;
}

// Handle job post creation
if (isset($_POST['createJobPost'])) {
    $job_title = $_POST['job_title'];
    $job_description = $_POST['job_description'];
    // Add database logic to insert the job post
    // Example: $models->createJobPost($job_title, $job_description);
    $_SESSION['message'] = "Job post created successfully!";
    header("Location: hr_dashboard.php"); // Redirect to avoid form resubmission
    exit;
}

// Handle application actions
if (isset($_GET['action']) && isset($_GET['application_id'])) {
    $action = $_GET['action'];
    $application_id = $_GET['application_id'];

    if ($action == 'accept') {
        // Accept the application
        // Example: $models->acceptApplication($application_id);
        $_SESSION['message'] = "Application accepted.";
    } elseif ($action == 'reject') {
        // Reject the application
        // Example: $models->rejectApplication($application_id);
        $_SESSION['message'] = "Application rejected.";
    }

    header("Location: hr_dashboard.php"); // Redirect to update the page state
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HR Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        main {
            padding: 20px;
        }
        h2 {
            margin-top: 40px;
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .message {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .success {
            background-color: #28a745;
            color: white;
        }
        .error {
            background-color: #dc3545;
            color: white;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>HR Dashboard</h1>
    <p>Welcome, HR representative! You can manage job posts and applications here.</p>
</header>

<main>
    <!-- Display Message if Set -->
    <?php if (isset($_SESSION['message'])) { ?>
        <div class="message <?= strpos($_SESSION['message'], 'success') !== false ? 'success' : 'error' ?>">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php } ?>

    <!-- Job Post Creation Form -->
    <section>
        <h2>Create a Job Post</h2>
        <form action="hr_dashboard.php" method="POST">
            <label for="job_title">Job Title</label>
            <input type="text" name="job_title" required>
            <label for="job_description">Job Description</label>
            <textarea name="job_description" required></textarea>
            <input type="submit" name="createJobPost" value="Create Job Post">
        </form>
    </section>

    <!-- Applications Section -->
    <section>
        <h2>Applications</h2>
        <p>Below are the applications you can accept or reject:</p>
        <table>
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Job Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example loop for applications -->
                <tr>
                    <td>John Doe</td>
                    <td>Software Engineer</td>
                    <td>
                        <a href="?action=accept&application_id=1">Accept</a>
                        <a href="?action=reject&application_id=1">Reject</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <!-- Messages Section -->
    <section>
        <h2>Messages from Applicants</h2>
        <p>View messages from applicants regarding their applications:</p>
        <table>
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jane Smith</td>
                    <td>Can you provide an update on my application?</td>
                </tr>
            </tbody>
        </table>
    </section>
</main>
<footer>
    <p>&copy; 2024 FindHire | <a href="logout.php">Logout</a></p>
</footer>

</body>
</html>
