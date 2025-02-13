
<?php
session_start();
?>

<?php
include 'db_config.php'; // Include your database connection file
if (!isset($_SESSION['valid'])) { // Check if the user is logged in
    echo "<script>alert('Please log in to perform this action'); window.location.href='homepage.php';</script>";
    exit();
}

// Check if the story ID is provided
if (isset($_GET['id'])) {
    $storyId = $_GET['id'];

    // Prepare and execute the query to fetch the story
    $stmt = $conn->prepare("SELECT * FROM stories WHERE id = :id");
    $stmt->bindParam(':id', $storyId, PDO::PARAM_INT);
    $stmt->execute();
    $story = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the story exists
    if (!$story) {
        echo "Story not found.";
        exit();
    }
} else {
    echo "No story ID provided.";
    exit();
}

// Handle form submission for updating the story
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Prepare the update statement
    $updateStmt = $conn->prepare("UPDATE stories SET title = :title, content = :content WHERE id = :id");
    $updateStmt->bindParam(':title', $title);
    $updateStmt->bindParam(':content', $content);
    $updateStmt->bindParam(':id', $storyId, PDO::PARAM_INT);

    // Execute the update statement
    if ($updateStmt->execute()) {
        // Redirect to stories.php with a success message
        header("Location: stories.php?message=Story updated successfully");
        exit();
    } else {
        // Redirect to stories.php with an error message
        header("Location: stories.php?message=Error updating story");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Story - Interactive Storytelling</title>
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

        form {
            display: inline-block;
            text-align: left;
        }

        label {
            font-size: 1.2em;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 10px 20px;
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
    </style>
</head>
<body>
    <header>
        <h1>Interactive Storytelling </h1>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="stories.php">Stories</a></li>
                <li><a href="add_story.php">Add Story</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Edit Story</h2>
        <form method="POST" action="">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($story['title']); ?>" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="10" required><?php echo htmlspecialchars($story['content']); ?></textarea>

            <button type="submit">Update Story</button>
        </form>
    </main>

    <footer>
        <p>&copy; 2024 Interactive Storytelling. All rights reserved.</p>
    </footer>
</body>
</html>