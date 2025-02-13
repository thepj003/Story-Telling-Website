<?php
session_start();
?>

<?php
include 'db_config.php'; // Include your database connection file

if (!isset($_SESSION['valid'])) { // Check if the user is logged in
    echo "<script>alert('Please log in to perform this action'); window.location.href='homepage.php';</script>";
    exit();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the story ID from the POST request
    $storyId = $_POST['id'];

    // Prepare the SQL statement to delete the story
    $stmt = $conn->prepare("DELETE FROM stories WHERE id = :id");
    $stmt->bindParam(':id', $storyId, PDO::PARAM_INT);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to stories.php with a success message
        header("Location: stories.php?message=Story deleted successfully");
        exit();
    } else {
        // Redirect to stories.php with an error message
        header("Location: stories.php?message=Error deleting story");
        exit();
    }
} else {
    // If not a POST request, redirect to stories.php
    header("Location: stories.php");
    exit();
}
?>