<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$usernameOrEmail = strtolower(trim($_POST['username']));

$password = trim($_POST['password']);

if (empty($usernameOrEmail) || empty($password)) {
    $_SESSION['user_message'] = "Please enter your username/email and password.";
    header("Location: ../../login.php");
    exit;
}

try {
    $stmt = $conn->prepare("
        SELECT user_id, username, email, password, role 
        FROM users 
        WHERE username = ? OR email = ?
        LIMIT 1
    ");

    if (!$stmt) {
        throw new Exception("Query error: " . $conn->error);
    }

    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION['user_message'] = "No account found with that username or email.";
        header("Location: ../../login.php");
        exit;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user['password'])) {
        $_SESSION['user_message'] = "Incorrect password.";
        header("Location: ../../login.php");
        exit;
    }

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['user_role'] = $user['role'];

    $_SESSION['user_message'] = "Welcome back, " . $user['username'] . "!";

    $_SESSION['redirect_after'] = "user/dashboard.php"; 
    
    header("Location: ../../login.php");
    exit;

} catch (Exception $e) {
    $_SESSION['user_message'] = "Login failed: " . $e->getMessage();
    header("Location: ../../login.php");
    exit;
}
