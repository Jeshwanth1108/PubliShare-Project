<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><i>PubliShare</i></title>
    <style>
        /* General Reset */
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            color: #333;
        }
        .navbar{
                background: #007bff; 
                font-family: 'Times New Roman'; 
                padding-right: 10px; 
                padding-left: 10px;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 1000;
                position: relative;
            }
            .navdiv{
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 20px 0;
            }
            .logo a{
                font-size: 35px; 
                font-weight: 600; 
                color: Red; 
                margin-left: 20px;
            }
            li{
                list-style: none;
                display: inline-block;
            }
            li a{
                color: white; 
                font-size: 20px; 
                font-weight: bold; 
                margin-right: 50px;
            }
            li button a{
                margin-left:15px;
            }
        /* Header */
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem 0;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        /* Container */
        .container {
            max-width: 1100px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        /* Search Form */
        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .search-form input[type="text"] {
            width: 70%;
            padding: 0.8rem;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search-form button {
            padding: 0.8rem;
            font-size: 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 0 4px 4px 0;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        /* Results Section */
        .results {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .result-item {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
        }

        .result-item h3 {
            margin-top: 0;
            color: #007bff;
        }

        .result-item p {
            margin: 0.5rem 0;
        }

        .result-item a {
            text-decoration: none;
            color: white;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            border-radius: 4px;
            margin-right: 0.5rem;
        }

        .result-item a:hover {
            background-color: #0056b3;
        }

        .result-item a.download {
            background-color: #28a745;
        }

        .result-item a.download:hover {
            background-color: #218838;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 1rem 0;
            background-color: #333;
            color: white;
            margin-top: 2rem;
        }
        .scroll-container {
    position: relative; /* Changed from fixed */
    margin-top: 10px; /* Space between navbar and scrolling bar */
    width: 100%;
    background-color: #f7f7f7;
    overflow: hidden;
    border-bottom: 2px solid #ccc;
    z-index: 1000;
}


.scroll-content {
    display: inline-block;
    white-space: nowrap;
    animation:scroll-left 20s linear infinite;
}

.scroll-content span {
    display: inline-block;
    padding: 0 20px;
    font-size: 1.2rem;
    color: #333;
}

@keyframes scroll-left {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}
.back{
    width: 80px;
    height: 30px;
    background-color: white; 
    border-radius: 30px;
}
    </style>
</head>
<body>

<header>
    <h1><i><b>Search Publications</b></i></h1>
</header>
<!-- Navigation Bar at the Top -->
<nav class="navbar">
        <div class="navdiv">
            <div class="logo"><a href="#"><i><b>PubliShare</b></i></a></div>
            <ul>
                <button><a href="registerr.php">login</a></button>
                <li><a href="#">Home</a></li>
                <li><a href="home.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Scrolling Bar Below the Navbar -->
    <div class="scroll-container">
        <div class="scroll-content">
            <span>🎉 Welcome to our website! Enjoy the latest updates! 🎉</span>
            <span>You can Search publications/projects developed by your faculty/professors</span>
            <span>You can Search publications/thesis based on topic, title or publishers(faculty).</span>

        </div>
    </div><br>
<div class="container">
    <!-- Search Form -->
    <form method="GET" action="search.php" class="search-form">
        <input type="text" name="query" placeholder="Enter topic, title, or uploader name" required>
        </i><button type="submit">Search</button>
    </form>

    <div class="results">
        <?php
        // Database connection
        $host = 'localhost';
        $db = 'miniproject'; // Replace with your database name
        $user = 'root';    // Replace with your database username
        $pass = '';    // Replace with your database password

        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("<p>Connection failed: " . $e->getMessage() . "</p>");
        }

        // Get the search query from the user
        $query = isset($_GET['query']) ? trim($_GET['query']) : '';

        if (!empty($query)) {
            // Prepare SQL query to search across topic, title, or uploader (faculty_name)
            $sql = "SELECT * FROM publications 
                    WHERE topic LIKE :query 
                       OR title LIKE :query 
                       OR faculty_name LIKE :query";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['query' => '%' . $query . '%']);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Display the results
            if (count($results) > 0) {
                foreach ($results as $row) {
                    echo "<div class='result-item'>
                            <h3>" . htmlspecialchars($row['title']) . "</h3>
                            <p><strong>Topic:</strong> " . htmlspecialchars($row['topic']) . "</p>
                            <p><strong>Uploaded by:</strong> " . htmlspecialchars($row['faculty_name']) . "</p><br>
                            <a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>View PDF</a>
                            <a href='" . htmlspecialchars($row['file_path']) . "' download class='download'>Download PDF</a>
                          </div>";
                }
            } else {
                echo "<p>No results found for '" . htmlspecialchars($query) . "'.</p>";
            }
        } else {
            echo "<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp Please enter a topic, title, or uploader's name to search.</p>";
        }
        ?>
    </div>
</div>
<center><button class="back"><a href="search.php">BACK</a></button></center>

<footer>
    <p>&copy;Search Publications. All rights reserved. Happy Learning!.</p>
</footer>

</body>
</html>
