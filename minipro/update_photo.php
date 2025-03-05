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

if (isset($_POST['submit'])) {
    // Handle the file upload
    $target_dir = "uploads/"; // Directory to store the uploaded photos
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an image
    if (getimagesize($_FILES["profile_photo"]["tmp_name"]) === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (limit to 2MB)
    if ($_FILES["profile_photo"]["size"] > 2000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats (JPEG, PNG, GIF)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if upload is okay
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            // Update the faculty profile with the new photo path
            $sql = "UPDATE faculty_registration SET profile_photo = '$target_file' WHERE id = '$faculty_id'";
            if ($conn->query($sql) === TRUE) {
                echo "The file has been uploaded and profile photo updated
