<?php
session_start();
//session_unset(); // Unset all session variables
//session_destroy(); // Destroy the session
//header("Location: homepage.php"); // Redirect to homepage.php
//exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Interactive Storytelling</title>
    <style>
header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
}
body{
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color:  #fff3e6;
    color: #333;
}

header h1 {
    margin: 0;
    font-size: 2.5em;
}

header nav {
    margin-top: 10px;
}

header nav ul {
    list-style: none;
    padding: 0;
    display: flex;
    justify-content: center;
}

header nav ul li {
    margin: 0 15px;
    background-color: #333;
}

header nav ul li a {
    color: #fff;
    text-decoration: none;
    font-size: 1.2em;
    transition: color 0.3s ease;
}

header nav ul li a:hover {
    color: #f4a261;
}

/* Main content */
main {
    padding: 40px;
    text-align: center;
}

h2 {
    font-size: 2em;
    margin-bottom: 30px;
    color: #2c3e50;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    background-color: #fff;
    padding: 20px;
    margin: 10px 0;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

ul li a {
    font-size: 1.5em;
    color: #2c3e50;
    text-decoration: none;
    font-weight: bold;
}

ul li a:hover {
    color: blue;
}

button {
    background-color: #ff4d4d;
    color: #fff;
    border: none;
    padding: 6px 12px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #e60000;
}



#stories {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    padding: 20px;
}

.story-card {
    background: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 300px;
    text-align: center;
}

.story-card a {
    text-decoration: none;
    color: #007BFF;
}

.story-card a:hover {
    text-decoration: underline;
}
/* Assuming this is in your style.css file */


.welcome-message {
    text-align: center; /* Center text horizontally */
    padding: 10px; /* Add some padding */
    font-size: 18px; /* Font size */
    color: #555; /* Change the color as needed */
    margin: 0 auto; /* Center the div itself if you want to add a width */
    width: 100%; /* Optional: Set width to 100% for full width */
}


    </style>
</head>
<header>
    <h1>Interactive Storytelling</h1>
    <nav>
        <ul>
            <li><a href="homepage.php">Home</a></li>
            <li><a href="add_story.php">Add Story</a></li>
            <li><a href="stories.php">Stories</a></li>
            <?php if (isset($_SESSION['valid'])): ?>
               
                <li><a href="logout.php" style=" color: red">Logout</a></li>
            <?php else: ?>
               
                <li><a href="index.php" id="login-btn" style=" color: skyblue">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<body>
<main>
        <div class="welcome-message">
                <?php if (isset($_SESSION['valid'])): ?>
                    <b><h3 style = "color: black;">Welcome, <?php echo $_SESSION['username']; ?>!</h3></b>
                <?php else: ?>
                    <b><p>Welcome, Guest!</p></b>
                <?php endif; ?>
        </div>
    <div id="stories">
        <!-- Stories will be dynamically loaded here -->
    </div>
</main>

    <script>fetch('story.php?action=list')
        .then(response => response.json())
        .then(data => {
            const storyContainer = document.getElementById('stories');
            storyContainer.innerHTML = data.map(story => `
                <div class="story-card">
                    <h3>${story.title}</h3>
                    <p>${story.description}</p>
                    <a href="story.php?id=${story.id}">Read More</a>
                </div>
            `).join('');
        });
    </script>
</body>
</html>