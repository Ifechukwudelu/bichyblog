<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['admin_message'] = "Please fill in all fields.";
        header("Location: ../login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT admin_id, admin_name, admin_email, admin_pass FROM admin_register WHERE admin_email = ? LIMIT 1");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        if (password_verify($password, $admin['admin_pass'])) {

            $_SESSION['admin_id'] = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['admin_name'];
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_message'] = "Welcome back, " . $admin['admin_name'] . "!";
            $_SESSION['redirect_after'] = "dashboard.php"; 

            header("Location: ../login.php");
            exit;
        } else {
            $_SESSION['admin_message'] = "Incorrect password.";
            header("Location: ../login.php");
            exit;
        }

    } else {
        $_SESSION['admin_message'] = "No account found with this email.";
        header("Location: ../login.php");
        exit;
    }

    $stmt->close();
    $conn->close();

} else {
    die("Invalid request.");
}
?>
