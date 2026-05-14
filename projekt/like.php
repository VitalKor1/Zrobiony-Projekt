<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    die("Error");
}

$post_id = $_POST['id'];
$user_id = $_SESSION['user_id'];


$check = $conn->prepare("SELECT id FROM post_likes WHERE post_id = ? AND user_id = ?");
$check->bind_param("ii", $post_id, $user_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {

    $stmt = $conn->prepare("DELETE FROM post_likes WHERE post_id = ? AND user_id = ?");
} else {

    $stmt = $conn->prepare("INSERT INTO post_likes (post_id, user_id) VALUES (?, ?)");
}

$stmt->bind_param("ii", $post_id, $user_id);
$stmt->execute();


$count = $conn->query("SELECT COUNT(*) as total FROM post_likes WHERE post_id = $post_id")->fetch_assoc();
echo $count['total'];
?>