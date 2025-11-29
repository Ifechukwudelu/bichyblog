<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $message = "";
    $redirectAfter = "";
    
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = strtolower(trim($_POST['username']));
    $password = $_POST['password'];
    $role = strtolower(trim($_POST['role']));

    if (empty($fullname) || empty($email) || empty($username) || empty($password) || empty($role)) {
        $_SESSION['user_message'] = "Please fill in all fields.";
        header("Location: ../../register.php");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['user_message'] = "Password must be at least 6 characters.";
        header("Location: ../../register.php");
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $conn->begin_transaction();

    try {
        $stmt1 = $conn->prepare("INSERT INTO users (name, email, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        if (!$stmt1) throw new Exception($conn->error);
        $stmt1->bind_param("sssss", $fullname, $email, $username, $password_hash, $role);
        $stmt1->execute();

        $user_id = $conn->insert_id;

        $stmt2 = $conn->prepare("INSERT INTO registered_users (user_id, name, email, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())");
        if (!$stmt2) throw new Exception($conn->error);
        $stmt2->bind_param("isssss", $user_id, $fullname, $email, $username, $password_hash, $role);
        $stmt2->execute();

        $conn->commit();

        $_SESSION['user_message'] = "Registration successful!";
        $_SESSION['redirect_after'] = "login.php";
        header("Location: ../../register.php");
        exit;

    } catch (Exception $e) {
        $conn->rollback();
        if ($conn->errno === 1062) {
            $_SESSION['user_message'] = "Email or username already exists.";
        } else {
            $_SESSION['user_message'] = "Error: " . $e->getMessage();
        }
        header("Location: ../../register.php");
        exit;
    }

    $stmt1->close();
    $stmt2->close();
    $conn->close();

} else {
    die("Invalid request.");
}
