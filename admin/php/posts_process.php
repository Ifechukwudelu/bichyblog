<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../dashboard.php");
    exit;
}

$action = $_POST['action'] ?? '';
$post_id = $_POST['post_id'] ?? 0;

if (!$post_id) {
    $_SESSION['admin_message'] = "Invalid Post ID!";
    header("Location: ../dashboard.php#posts");
    exit;
}

//    APPROVE POST

   if ($action === "approve") {

    $sql = "UPDATE posts SET status='approved' WHERE post_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        $_SESSION['admin_message'] = "Post approved successfully.";
    } else {
        $_SESSION['admin_message'] = "Error approving post.";
    }

    $stmt->close();
}

//    DELETE POST

   elseif ($action === "delete") {

    $sql = "DELETE FROM posts WHERE post_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $post_id);

    if ($stmt->execute()) {
        $_SESSION['admin_message'] = "Post deleted.";
    } else {
        $_SESSION['admin_message'] = "Error deleting post.";
    }

    $stmt->close();
}

//    INVALID ACTION

   else {
    $_SESSION['admin_message'] = "Invalid action.";
}

header("Location: ../dashboard.php#posts");
exit;

?>
              
 