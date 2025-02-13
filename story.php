<?php
session_start();
?>

<?php
include 'db_config.php';

// Check if 'action' is set in the GET request
if (isset($_GET['action']) && $_GET['action'] === 'list') {
    $stmt = $conn->query("SELECT id, title, description FROM stories");
    $stories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($stories);
} else if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT title, content FROM stories WHERE id = ?");
    $stmt->execute([$id]);
    $story = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($story) {
        echo "<h1>{$story['title']}</h1><p>{$story['content']}</p>";
    } else {
        echo "<h1>Story not found!</h1>";
    }
} else {
    echo "<h1>No action specified!</h1>"; // Optional: Handle case where no action is specified
}
?>