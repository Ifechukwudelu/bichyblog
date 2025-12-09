<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "bichyblog";

$conn = new mysqli ($host, $user, $pass, $db);
if($conn->connect_error){
    throw new Exception($conn->connect_error);
} 
try{
   $users = "
   CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

";

  $adminRegister = "
  CREATE TABLE IF NOT EXISTS `admin_register` (
  `admin_id` int(20) NOT NULL AUTO_INCREMENT,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(100) NOT NULL,
  `admin_username` varchar(100) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_email` (`admin_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
";

$posts = "
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `category` enum('timeless','oldNewYork','cultural') NOT NULL,
  `status` enum('pending','approved') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),

  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

"; 

$registeredUsers = "
CREATE TABLE IF NOT EXISTS `registered_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  KEY `fk_user_id` (`user_id`),
  
  CONSTRAINT `fk_user_id` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `users` (`user_id`) 
    ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

";

$userDp = "
CREATE TABLE IF NOT EXISTS `user_dp` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(50) DEFAULT NULL,
  `user_dp` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `fk_dp_id` FOREIGN KEY (`user_id`)
    REFERENCES `users` (`user_id`)
    ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

";

$bichyTables = [$users, $registeredUsers, $userDp, $posts, $adminRegister,];

foreach ($bichyTables as $tables) {
  $conn->query($tables);
}

} catch (Exception $e) {
    header('Content-Type: application/json');
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
    exit;
}
?>