<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once __DIR__ . '/../../php/auth_check.php';
include_once __DIR__ . '/../../php/db_config.php';

$message = "";
$redirectAfter = "";
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    $_SESSION['user_message'] = "Please login to continue.";
    header("Location: ../../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $form_type = $_POST['form_type'] ?? '';

    if ($form_type === 'dp') {

        $dpPath = null;

        if (!empty($_FILES['user_dp']['name'])) {
            $targetDir = "../user_img/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $dpPath = $targetDir . basename($_FILES["user_dp"]["name"]);
            move_uploaded_file($_FILES["user_dp"]["tmp_name"], $dpPath);
        }

        if ($dpPath) {
            $sql = "INSERT INTO user_dp (user_id, user_dp)
                    VALUES (?, ?)
                    ON DUPLICATE KEY UPDATE user_dp = VALUES(user_dp)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $dpPath);
            $stmt->execute();
            $stmt->close();

            $_SESSION['user_message'] = "Profile picture updated.";
            header("Location: ../dashboard.php#profile");
            exit;

        } else {
            $_SESSION['user_message'] = "No image selected.";
            header("Location: ../dashboard.php#profile");
            exit;
        }

        
    }


    if ($form_type === 'update_user') {

        $fullname = trim($_POST['fullname']);
        $email = trim($_POST['email']);
        $username = strtolower(trim($_POST['username']));
        $password = trim($_POST['password']);
        $role = trim($_POST['role']);

        $updatePasswordSQL = "";
        $params = [$fullname, $email, $username, $role, $user_id];
        $types = "ssssi";

        if (!empty($password)) {
            $updatePasswordSQL = ", password = ?";
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $params = [$fullname, $email, $username, $role, $hashed, $user_id];
            $types = "sssssi";
        }

        $sql = "UPDATE users 
                SET name=?, email=?, username=?, role=? $updatePasswordSQL WHERE user_id=?";

        $stmt = $conn->prepare($sql);

        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            $_SESSION['user_message'] = "Profile updated successfully.";
            header("Location: ../dashboard.php#details");
            exit;
        } else {
            $_SESSION['user_message'] = "An error occurred while updating profile.";
            header("Location: ../dashboard.php#details");
            exit;
        }

        $stmt->close();

    }

    //    POST ARTICLE

       if ($form_type === 'post_article') {

        $category = $_POST['category']; 
        $title = $_POST['title'];
        $content = $_POST['content'];

        $postImgPath = null;

        if (!empty($_FILES['article_image']['name'])) {
            $targetDir = "../user_img";
            if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

            $postImgPath = $targetDir . basename($_FILES["article_image"]["name"]);
            move_uploaded_file($_FILES["article_image"]["tmp_name"], $postImgPath);
        }

        $sql = "INSERT INTO posts (user_id, title, content, image_path, category, status, created_at)
                VALUES (?, ?, ?, ?, ?, 'pending', NOW())
                ON DUPLICATE KEY UPDATE 
                user_id = VALUES(user_id),
                title = VALUES(title),
                content = VALUES(content),
                image_path = VALUES(image_path),
                category = VALUES(category),
                status = VALUES(status)
                ";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issss", $user_id, $title, $content, $postImgPath, $category);

        if ($stmt->execute()) {
            $_SESSION['user_message'] = "Article sent for admin approval.";
            header("Location: ../dashboard.php#post");
            exit;
        } else {
            $_SESSION['user_message'] = "Error posting your article.";
            header("Location: ../dashboard.php#post");
            exit;
        }

        $stmt->close();

    }

}
?>
