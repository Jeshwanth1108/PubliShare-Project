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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $conn->real_escape_string($_POST['userId']);
    $password = $conn->real_escape_string($_POST['password']);

    // Query to verify credentials
    $sql = "SELECT * FROM faculty_registration WHERE id = '$userId' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        $_SESSION['faculty_id'] = $row['id']; // Save faculty ID in session
        header("Location: dashboard.php?userId=" . urlencode($row['id']));
        exit(); // Stop further script execution after redirection
    } else {
        $error = "Invalid User ID or Password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Login</title>
    <style>
        /* Base styling */
        body {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            font-family: 'Arial', sans-serif;
            color: white;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Flex container for the login box */
        .login-container {
            width: 100%;
            max-width: 400px;
            background: rgba(0, 0, 0, 0.85);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 20px;
        }

        /* Header */
        .login-container h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            color: #81C784;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Input fields */
        .login-container input {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            margin: 0;
            border: none;
            border-radius: 8px;
            outline: none;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            transition: background-color 0.3s;
        }

        .login-container input:focus {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Button styles */
        .login-container button {
            width: 100%;
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            color: white;
            background: #81C784;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .login-container button:hover {
            background: #66BB6A;
            transform: scale(1.05);
        }

        .login-container button a {
            text-decoration: none;
            color: white;
        }

        /* Error message */
        .error {
            color: #FF6B6B;
            font-size: 14px;
            margin-top: 5px;
        }

        /* Spacing between elements */
        .login-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            width: 100%;
        }

        .register-button {
            margin-top: 10px;
            background: #FF7043;
        }

        .register-button:hover {
            background: #F4511E;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Faculty Login</h2>
        <form method="POST" action="" autocomplete="off">
    <input type="text" name="userId" placeholder="User ID" value="" required>
    <input type="password" name="password" placeholder="Password" value="" required>

             <button type="submit">Login</button>
            <button class="register-button"><a href="registerr.php">new user? <br> Create Account</a></button>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        </form>
    </div>
</body>
</html>
