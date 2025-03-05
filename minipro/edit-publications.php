<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Update with your MySQL username
$password = "";     // Update with your MySQL password
$dbname = "miniproject"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit();
}

$faculty_id = $_SESSION['faculty_id'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_selected'])) {
    if (!empty($_POST['delete_ids'])) {
        // Sanitize and prepare for SQL query
        $delete_ids = implode(',', array_map('intval', $_POST['delete_ids']));
        $sql_delete = "DELETE FROM publications WHERE sl_no IN ($delete_ids) AND faculty_id = '$faculty_id'";

        if ($conn->query($sql_delete) === TRUE) {
            $message = "Selected publications deleted successfully!";
        } else {
            $message = "Error deleting publications: " . $conn->error;
        }
    } else {
        $message = "No publications selected for deletion.";
    }
}

// Fetch all publications uploaded by the logged-in faculty member
$sql_publications = "SELECT sl_no, title, topic, file_path FROM publications WHERE faculty_id = '$faculty_id'";
$result_publications = $conn->query($sql_publications);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Publications</title>
    <style>
        body {
            background: linear-gradient(to right, #141e30, #243b55);
            font-family: Arial, sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #81c784;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: white;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #2e7d32;
            color: white;
            font-weight: bold;
        }
        .checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .btn-delete {
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
        }
        .btn-delete:hover {
            background-color: #d32f2f;
        }
        .btn-view {
            display: inline-block;
            background-color: #3f51b5;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }
        .btn-view:hover {
            background-color: #303f9f;
        }
        .message {
            text-align: center;
            color: #81c784;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Publications</h1>
        <?php
        // Display message if available
        if (isset($message)) {
            echo "<p class='message'>$message</p>";
        }
        ?>
        <form method="POST" action="">
            <table>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Topic</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display publications uploaded by the faculty member
                    if ($result_publications && $result_publications->num_rows > 0) {
                        while ($publication = $result_publications->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td><input type='checkbox' class='checkbox' name='delete_ids[]' value='" . $publication['sl_no'] . "'></td>";
                            echo "<td>" . $publication['sl_no'] . "</td>";
                            echo "<td>" . $publication['title'] . "</td>";
                            echo "<td>" . $publication['topic'] . "</td>";
                           echo "<td>
        <a href='uploads/" . urlencode($publication['file_path']) . "' class='btn-view' target='_blank'>View PDF</a>
      </td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No publications found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div style="text-align: center;">
                <button type="submit" class="btn-delete" name="delete_selected">Delete Selected</button>
            </div>
        </form>
    </div>
</body>
</html>

