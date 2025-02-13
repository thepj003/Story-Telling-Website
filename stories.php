<?php
session_start();
?>

<?php

include 'db_config.php'; // Include your database connection file

// Query to fetch all stories from the database
$stmt = $conn->prepare("SELECT * FROM stories");
$stmt->execute();
$stories = $stmt->fetchAll(); // Fetch all the stories
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stories - Interactive Storytelling</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* General body styling */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

/* Header section */
header {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
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

form {
    display: inline;
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

/* Footer section */
footer {
    background-color: #333;
    color: #fff;
    padding: 20px;
    text-align: center;
    font-size: 1em;
}

footer p {
    margin: 0;
}

/* Media queries for responsiveness */
@media (max-width: 768px) {
    ul li {
        flex-direction: column;
        align-items: flex-start;
    }

    header nav ul {
        flex-direction: column;
    }

    header nav ul li {
        margin-bottom: 10px;
    }
}

    </style>
</head>
<body>
    <!-- Navigation Bar or Header -->
    <header>
        <h1>Interactive Storytelling</h1>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="stories.php">Stories</a></li>
                <li><a href="add_story.php">Add Story</a></li>
                
            </ul>
        </nav>
    </header>

    <!-- Main Content -->
    <main>
        <h2>Available Stories</h2>

        <?php if (count($stories) > 0): ?>
            <ul>
    <?php foreach ($stories as $story): ?>
        <li>
            <a href="story.php?id=<?php echo $story['id']; ?>">
                <?php echo htmlspecialchars($story['title']); ?>
            </a>
            <div>
                <form action="delete_story.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $story['id']; ?>">
                    <button type="submit" style="border: none; background: none; padding: 0;">
                        <img src="stories/delete.png" alt="Delete" style="width: 20px; height: 20px; cursor: pointer;">
                    </button>
                </form>
                <form action="edit_story.php" method="GET" style="display:inline;">
                    <input type="hidden" name="id" value="<?php echo $story['id']; ?>">
                    <button type="submit" style="border: none; background: none; padding: 0;">
                        <img src="stories/edit.png" alt="Edit" style="width: 20px; height: 20px; cursor: pointer;">
                    </button>
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
        <?php else: ?>
            <p>No stories available at the moment. Please check back later.</p>
        <?php endif; ?>

    </main>

    <!-- Footer -->
    

</body>
</html>