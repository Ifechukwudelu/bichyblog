<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../dashboard.php#users");
    exit;
}

$message = "";
$redirectAfter = "";

$action = $_POST['action'] ?? '';
$user_id = $_POST['user_id'] ?? 0;

if (!$user_id) {
    $_SESSION['admin_message'] = "Invalid User ID!";
    header("Location: ../dashboard.php#users");
    exit;
}

//    DELETE USER

if ($action === "delete") {

    $sql = "DELETE FROM users WHERE user_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    $_SESSION['admin_message'] = $stmt->execute()
        ? "User deleted successfully."
        : "Error deleting user.";

    $stmt->close();
}

//    INVALID ACTION

else {
    $_SESSION['admin_message'] = "Invalid action.";
}

header("Location: ../dashboard.php#users");
exit;
