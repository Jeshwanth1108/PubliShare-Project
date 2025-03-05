<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "miniproject";

// Check if the user is logged in
if (!isset($_SESSION['faculty_id'])) {
    header("Location: login.php");
    exit();
}

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve faculty_name based on session faculty_id
$faculty_id = $_SESSION['faculty_id'];
$sql = "SELECT name FROM faculty_registration WHERE id = '$faculty_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $faculty_name = $row['name'];
} else {
    $faculty_name = "Unknown"; // Fallback if no name is found
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST['title']);
    $topic = $conn->real_escape_string($_POST['topic']);

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $fileName = $_FILES['file']['name'];
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $uploadDir = "uploads/";
        $filePath = $uploadDir . basename($fileName);

        if (move_uploaded_file($fileTmpPath, $filePath)) {
            // Insert into database
            $sql = "INSERT INTO publications (faculty_id, title, topic, faculty_name, file_path) 
                    VALUES ('$faculty_id', '$title', '$topic', '$faculty_name', '$filePath')";
            
            if ($conn->query($sql) === TRUE) {
                $success = "Publication uploaded successfully!";
            } else {
                $error = "Error: " . $conn->error;
            }
        } else {
            $error = "Failed to upload file.";
        }
    } else {
        $error = "Please select a valid file.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Publication</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #141e30, #243b55);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: white;
        }
        .upload-container {
            width: 90%;
            max-width: 500px;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.5);
        }
        .upload-container h2 {
            text-align: center;
            font-size: 26px;
            margin-bottom: 20px;
            color: #50c878;
        }
        .upload-container form {
            display: flex;
            flex-direction: column;
        }
        .upload-container label {
            margin-bottom: 8px;
            font-weight: bold;
            font-size: 14px;
        }
        .upload-container input,
        .upload-container select,
        .upload-container textarea {
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .upload-container input[disabled] {
            background: rgba(255, 255, 255, 0.2);
            color: #ddd;
        }
        .upload-container input::placeholder,
        .upload-container textarea::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }
        .upload-container button {
            padding: 12px;
            background: #50c878;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }
        .upload-container button:hover {
            background: #45b565;
        }
        .back-btn {
            background: #f05454;
            margin-top: 10px;
        }
        .back-btn:hover {
            background: #d84545;
        }
        .message {
            text-align: center;
            margin: 10px 0;
            font-size: 16px;
        }
        .message.success {
            color: #50c878;
        }
        .message.error {
            color: #f05454;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2>Upload Your Publication</h2>
        <?php if (isset($success)) { echo "<p class='message success'>$success</p>"; } ?>
        <?php if (isset($error)) { echo "<p class='message error'>$error</p>"; } ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter publication title" required>

            <label for="topic">Topic</label>
            <input type="text" id="topic" name="topic" placeholder="Enter publication topic" required>

            <label for="faculty_name">Faculty Name</label>
            <input type="text" id="faculty_name" name="faculty_name" value="<?php echo htmlspecialchars($faculty_name); ?>" disabled>

            <label for="file">Upload File (PDF)</label>
            <input type="file" id="file" name="file" accept=".pdf" required>

            <button type="submit">Upload</button>
        </form>
        <form action="dashboard.php" method="get">
            <button type="submit" class="back-btn">Back</button>
        </form>
    </div>
</body>
</html>

