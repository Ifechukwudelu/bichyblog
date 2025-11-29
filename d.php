<?php
$config = require __DIR__ . '/../else/config.php';

$host = $config["DB_HOST"];
$user = $config["DB_USER"];
$pass = $config["DB_PASS"];
$db = $config["DB_NAME"];

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Local DB failed: " . $conn->connect_error);

try {

$connectTable = "

CREATE TABLE IF NOT EXISTS `connect` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `message` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$applyNowTable = "

CREATE TABLE IF NOT EXISTS `apply_now` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `program` varchar(50) NOT NULL,
  `category` enum('Student','Staff') NOT NULL,
  `message` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$loginTable = "

CREATE TABLE IF NOT EXISTS `login` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `category` enum('Student','Staff') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$usersTable = "
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `program` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$blogPostsTable = "

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `topic` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date_posted` date NOT NULL,
  `posted_by` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','deleted') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$staffVerificationTable = "

CREATE TABLE IF NOT EXISTS `staff_verification` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `staff_image` varchar(255) NOT NULL,
  `staff_name` varchar(150) NOT NULL,
  `staff_post` varchar(150) NOT NULL,
  `staff_quote` text DEFAULT NULL,
  `staff_category` enum('University Leadership','Academic Staff','Non-Academic Staff') NOT NULL,
  `verified_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','approved','deleted') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  UNIQUE KEY `staff_name` (`staff_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$programsTable ="

CREATE TABLE IF NOT EXISTS `programs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$userImagetable = "

CREATE TABLE IF NOT EXISTS `user_image` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(20) DEFAULT NULL,
  `user_image` varchar(200) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$tables = [$connectTable, $loginTable, $applyNowTable, $usersTable, $blogPostsTable, $staffVerificationTable, $programsTable, $userImagetable]; 

foreach ($tables as $sql) {
   $conn->query($sql);
}

}catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
    exit;
}
?>