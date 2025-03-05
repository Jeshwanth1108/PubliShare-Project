<?php
// Start the session
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

// Fetch the publication record for a specific faculty member
$sql_publications = "SELECT sl_no, title, topic, file_path FROM publications WHERE faculty_id = '$faculty_id'";
$result_publications = $conn->query($sql_publications);

// Check if a publication ID is passed for viewing the PDF
if (isset($_GET['view_pdf'])) {
    $publication_id = $_GET['view_pdf'];
    $sql_pdf = "SELECT file_path FROM publications WHERE sl_no = '$publication_id' AND faculty_id = '$faculty_id'";
    $result_pdf = $conn->query($sql_pdf);
    $pdf_data = $result_pdf->fetch_assoc();
    $pdf_file = 'uploads/' . $pdf_data['file_path'];  // Path to the PDF file
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View PDF</title>
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
        iframe {
            width: 100%;
            height: 600px;
            border: none;
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
    </style>
</head>
<body>

<div class="container">
    <h1>View Publication PDF</h1>

    <?php
    // Display PDF inside an iframe if the file exists
    if (isset($pdf_file) && file_exists($pdf_file)) {
        echo "<iframe id='pdf-viewer' src='$pdf_file'></iframe>";
    } else {
        echo "<p>PDF file not found or invalid publication.</p>";
    }
    ?>

    <!-- Button to open PDF in a new tab -->
    <div style="text-align: center; margin-top: 20px;">
        <?php
        if (isset($pdf_file)) {
            echo "<a href='$pdf_file' class='btn-view' target='_blank'>View PDF in New Tab</a>";
        }
        ?>
    </div>
</div>

</body>
</html>

