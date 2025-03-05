<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Update with your database username
$password = "";     // Update with your database password
$dbname = "miniproject"; // Update with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$id = $_POST['id']; // 'id' corresponds to the primary key
$pwd = $_POST['pwd'];
$name = $_POST['name'];
$department = $_POST['dep'];
$qualification = $_POST['qualification'];
$achievements = $_POST['achieve'];

// Handle the profile photo upload
$target_dir = "uploads/"; // Directory where files will be uploaded
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
}
$profile_photo = $target_dir . basename($_FILES["profile_photo"]["name"]);

// Move the uploaded file to the target directory
if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $profile_photo)) {
    // File successfully uploaded
} else {
    die("Error uploading profile photo.");
}

// SQL query to insert data into the faculty_registration table
$sql = "INSERT INTO faculty_registration (id, password, name, department, qualification, achievements, profile_photo) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

// Prepare and bind
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $id, $pwd, $name, $department, $qualification, $achievements, $profile_photo);

// Execute the query
if ($stmt->execute()) {
    echo "<p>Registration successful!</p>";
    echo "<p><a href='success.php'>Click here to verify your registration!</a></p>";
} else {
    echo "Error: " . $stmt->error;
}

// Close the connection
$stmt->close();
$conn->close();
?>

