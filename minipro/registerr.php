<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Page</title>
    <style>
        /* Reset and Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.15);
            width: 100%;
            max-width: 500px;
            padding: 30px 40px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.3);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-container h1 {
            font-size: 30px;
            color: #fff;
            margin-bottom: 20px;
            font-weight: 900;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-container label {
            font-size: 14px;
            color: #fff;
            text-align: left;
        }

        .form-container input[type="number"],
        .form-container input[type="text"],
        .form-container input[type="file"] {
            padding: 12px;
            font-size: 14px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9); /* White background */
            color: #000 !important; /* Black text */
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-container input[type="number"]::placeholder,
        .form-container input[type="text"]::placeholder {
            color: rgba(0, 0, 0, 0.7); /* Gray placeholders */
        }

        .form-container input[type="number"]:focus,
        .form-container input[type="text"]:focus,
        .form-container input[type="file"]:focus {
            border-color: #6dd5ed;
            box-shadow: 0 0 8px rgba(109, 213, 237, 0.7);
        }

        .form-container input[type="submit"] {
            padding: 12px;
            font-size: 16px;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .form-container input[type="submit"]:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(109, 213, 237, 0.5);
        }

        .form-container input[type="submit"]:active {
            transform: translateY(1px);
        }

        .form-container p {
            margin-top: 10px;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .form-container p a {
            color: #6dd5ed;
            text-decoration: none;
            font-weight: bold;
        }

        .form-container p a:hover {
            text-decoration: underline;
        }
    </style>
    <script>
        // Function to validate password length
        function validateForm() {
            const password = document.getElementById("pwd").value;

            // Check if the password has at least 8 characters
            if (password.length < 8) {
                alert("Password must be at least 8 characters long!");
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>User Registration</h1>
        <form name="form1" action="in.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
            <label for="id">ID</label>
            <input type="text" id="id" name="id" placeholder="Enter User Id" required>

            <label for="pwd">Password</label>
            <input type="text" id="pwd" name="pwd" placeholder="Enter password" required>

            <label for="name">User Name</label>
            <input type="text" id="name" name="name" placeholder="Enter full name" required>

            <label for="dep">Department</label>
            <input type="text" id="dep" name="dep" placeholder="Enter department" required>

            <label for="qualification">Qualification</label>
            <input type="text" id="qualification" name="qualification" placeholder="Enter qualification" required>

            <label for="achieve">Achievements</label>
            <input type="text" id="achieve" name="achieve" placeholder="Enter achievements" required>

            <label for="profile_photo">Profile Photo</label>
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" required>

            <input type="submit" value="Submit">
        </form>
        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

