<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $message = "";

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['admin_message'] = "Passwords do not match.";
        header("Location: ../register.php");
        exit;
    }

    if (strlen($password) < 6) {
        $_SESSION['admin_message'] = "Password must be at least 6 characters.";
        header("Location: ../register.php");
        exit;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $admin = $conn->prepare("INSERT INTO admin_register (admin_name, admin_email, admin_username, admin_pass) VALUES (?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
                    admin_name = VALUES(admin_name),
                    admin_email = VALUES(admin_email),
                    admin_username = VALUES(admin_username),
                    admin_pass = VALUES(admin_pass)
                ");

    if (!$admin) {
        die("Prepare failed: " . $conn->error);
    }

    $admin->bind_param("ssss", $fullname, $email, $username, $password_hash);

    if ($admin->execute()) {
        $_SESSION['admin_message'] = "Admin registered successfully!";
        $_SESSION['redirect_after'] = "login.php";

        header("Location: ../register.php");
        exit;

    } else {
        if ($conn->errno === 1062) {
            $_SESSION['admin_message'] = "Email or Username already exists.";
            header("Location: ../register.php");
            exit;
        } else {
            echo "Error: " . $admin->error;
        }
    }

    $admin->close();
    $conn->close();
} else {
    die("Invalid request.");
}
?>
