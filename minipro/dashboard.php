<?php
session_start();

$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = "";     // Replace with your MySQL password
$dbname = "miniproject"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Fetch faculty data
$sql = "SELECT * FROM faculty_registration WHERE id = '$faculty_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $faculty = $result->fetch_assoc();
} else {
    die("Faculty not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            font-family: 'Arial', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .profile-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-section img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }
        .profile-section h2 {
            margin: 10px 0 5px;
            font-size: 24px;
            font-weight: bold;
        }
        .profile-section p {
            font-size: 16px;
            margin: 5px 0;
        }
        .profile-details {
            margin-top: 20px;
        }
        .profile-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .profile-details th, .profile-details td {
            text-align: left;
            padding: 10px;
            border-bottom: 1px solid white;
        }
        .profile-details th {
            font-size: 18px;
            font-weight: bold;
            color: #81c784;
        }
        .profile-details td {
            font-size: 16px;
            color: white;
        }
        .scrollable-cell {
            max-height: 150px; /* Keeps the content within a specific height */
            overflow-y: auto; /* Enables vertical scrolling */
            overflow-x: hidden; /* Prevents horizontal scrolling */
            white-space: normal; /* Allows text wrapping */
            word-wrap: break-word; /* Ensures words break correctly */
            word-break: break-word; /* Breaks long words to prevent overflow */
            overflow-wrap: break-word; /* Additional word-breaking for compatibility */
            padding: 10px; /* Adds padding for readability */
            border: 1px solid rgba(255, 255, 255, 0.2); /* Optional border for clarity */
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.1); /* Keeps the box styling */
            box-sizing: border-box; /* Ensures padding does not affect the size */
            text-align: justify; /* Ensures text is justified for better appearance */
        }
        .action-buttons {
            text-align: center;
            margin-top: 20px;
        }
        .action-buttons a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background: #81c784;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            transition: 0.3s;
            margin: 10px;
        }
        .action-buttons a:hover {
            background: #66bb6a;
        }
        .action-buttons p {
            margin-top: 10px;
            font-size: 14px;
            color: #cccccc;
        }
        .action-buttons a.upload {
            background: #4fc3f7;
        }
        .action-buttons a.upload:hover {
            background: #039be5;
        }
        .action-buttons a.logout {
            background: #f44336;
        }
        .action-buttons a.logout:hover {
            background: #d32f2f;
        }
        .action-buttons a.edit-publications {
            background: #ff9800;
        }
        .action-buttons a.edit-publications:hover {
            background: #fb8c00;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="profile-section">
            <img src="<?php echo $faculty['profile_photo']; ?>" alt="Profile Photo">
            <h2><?php echo htmlspecialchars($faculty['name']); ?></h2>
            <p><?php echo htmlspecialchars($faculty['department']); ?></p>
        </div>
        <div class="profile-details">
            <table>
                <tr>
                    <th>Qualification:</th>
                    <td class="scrollable-cell"><?php echo nl2br(htmlspecialchars($faculty['qualification'])); ?></td>
                </tr>
                <tr>
                    <th>Achievements:</th>
                    <td class="scrollable-cell"><?php echo nl2br(htmlspecialchars($faculty['achievements'])); ?></td>
                </tr>
            </table>
        </div>
        <div class="action-buttons">
            <a href="view.php" class="view">View Publications</a>
            <a href="upload.php" class="upload">Upload My Publications</a>
            <p>Upload your research/publications in PDF format only.</p>
            <a href="edit-publications.php" class="edit-publications">Edit Publications</a>
            <a href="edit-profile.php">Edit Profile</a>
            <a href="logout.php" class="logout">Logout</a>
        </div>
    </div>
</body>
</html>

