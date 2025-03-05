<!-- index.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publication Viewer</title>
</head>
<body>
    <nav>
        <a href="faculty_login.php">Faculty Login</a>
    </nav>
    <h1>Search Publications</h1>
    <form action="search_results.php" method="GET">
        <input type="radio" id="title" name="search_by" value="title" required>
        <label for="title">Title</label>
        <input type="radio" id="topic" name="search_by" value="topic">
        <label for="topic">Topic</label>
        <input type="radio" id="professor" name="search_by" value="professor">
        <label for="professor">Professor</label>
        <br>
        <input type="text" name="query" placeholder="Enter search text" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>


<body>
        <!-- Navigation Bar at the Top -->
        <nav class="navbar">
            <div class="navdiv">
                <div class="logo"><a href="#"><i><b>PubliShare</b></i></a></div>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Contact</a></li>
                    <button><a href="#">Faculty login</a></button>
                </ul>
            </div>
        </nav>
        
            <div class="scroll-container">
        <div class="scroll-content">
            <span>🎉 Welcome to our website! Enjoy the latest updates! 🎉</span>
            <span>🎉 Check out our new features and announcements! 🎉</span>
        </div>
    </div>
   <br>
        <!-- Centered Heading Below the Navbar -->
        <center><h1>PubliShare</h1></center>
        <br><br>
        <form action="search_results.php" method="GET">
        <input type="radio" id="title" name="search_by" value="title" required>
        <label for="title" class="text">Title</label><br><br>
        <input type="radio" id="topic" name="search_by" value="topic">
        <label for="topic" class="text">Topic</label><br><br>
        <input type="radio" id="professor" name="search_by" value="professor">
        <label for="professor" class="text">Professor</label>
        <br><br><br>
        <!-- Search Bar Below Heading -->
        <div class="box">
            <input type="text" placeholder="Search....">
            <a href="#">
                <i class="fas fa-search"></i>
            </a>
        </div>
        </form>
    </body>
