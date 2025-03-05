<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <style>
        /* General styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        /* Container styles */
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 90%;
        }

        /* Heading styles */
        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #4CAF50;
        }

        /* Button styles */
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, #2575fc, #6a11cb);
            color: white;
            text-transform: uppercase;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            text-decoration: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(90deg, #6a11cb, #2575fc);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>You're Successfully Registered!</h1>
        <p>Thank you for registering. Click the button below to go back to the login page.</p>
        <a href="login.php" class="btn">Back to Login</a>
    </div>
</body>
</html>
