<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject";

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
$success_message = "";
$error_message = "";

// Fetch existing user data
$sql = "SELECT * FROM faculty_registration WHERE id = '$faculty_id'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $faculty = $result->fetch_assoc();
} else {
    die("Faculty not found.");
}

// Update profile data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $department = $conn->real_escape_string($_POST['department']);
    $qualification = $conn->real_escape_string($_POST['qualification']);
    $achievements = $conn->real_escape_string($_POST['achievements']);

    // Handle file upload
    $profile_photo = $faculty['profile_photo'];
    if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $file_name = basename($_FILES['profile_photo']['name']);
        $target_file = $target_dir . time() . "_" . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
                $profile_photo = $target_file;
            } else {
                $error_message = "Failed to upload profile photo.";
            }
        } else {
            $error_message = "Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    }

    // Update database
    if (!$error_message) {
        $sql = "UPDATE faculty_registration SET 
                    name = '$name', 
                    department = '$department', 
                    qualification = '$qualification', 
                    achievements = '$achievements', 
                    profile_photo = '$profile_photo' 
                WHERE id = '$faculty_id'";

        if ($conn->query($sql) === TRUE) {
            // Redirect to dashboard page after successful update
            header("Location: dashboard.php");
            exit();
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            background: linear-gradient(to right, #1e3c72, #2a5298);
            font-family: 'Arial', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
        }
        .edit-container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .edit-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #81c784;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group input[type="file"] {
            border: none;
            background: white;
            color: black;
        }
        .form-group textarea {
            height: 100px;
        }
        .profile-photo {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-photo img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid white;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #81c784;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #66bb6a;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            font-size: 14px;
        }
        .message.success {
            color: #4caf50;
        }
        .message.error {
            color: #f44336;
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Profile</h2>
        <div class="profile-photo">
            <img src="<?php echo $faculty['profile_photo']; ?>" alt="Profile Photo">
        </div>
        <?php if ($success_message) echo "<p class='message success'>$success_message</p>"; ?>
        <?php if ($error_message) echo "<p class='message error'>$error_message</p>"; ?>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?php echo $faculty['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="department">Department</label>
                <input type="text" name="department" id="department" value="<?php echo $faculty['department']; ?>" required>
            </div>
            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" name="qualification" id="qualification" value="<?php echo $faculty['qualification']; ?>" required>
            </div>
            <div class="form-group">
                <label for="achievements">Achievements</label>
                <textarea name="achievements" id="achievements"><?php echo $faculty['achievements']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo">
            </div>
            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>

