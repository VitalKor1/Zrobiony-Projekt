<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['id'])) {
    $post_id = $_POST['id'];
    $current_user = $_SESSION['user_id'] ?? 0;

    if ($current_user == 999) {

        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->bind_param("i", $post_id);
    } else {

        $stmt = $conn->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $post_id, $current_user);
    }

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Error";
    }
}
?>