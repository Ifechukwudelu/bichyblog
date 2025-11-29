<?php
          
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';

$admin_id = $_SESSION['admin_id'] ?? null;

if ($admin_id) {

    $admin_info = $conn->prepare(
        "SELECT admin_name, admin_email, admin_username 
         FROM admin_register 
         WHERE admin_id = ?"
    );

    $admin_info->bind_param("i", $admin_id);
    $admin_info->execute();

    $result = $admin_info->get_result();
    $info = $result->fetch_assoc();

    $admin_info->close();
}
?>


    <div id="profile" class="tab-content">
        <h2 class="text-3xl font-bold mb-4">Admin Profile</h2>
        <p><?=htmlspecialchars($info['admin_name'])?></p>
        <p><?=htmlspecialchars($info['admin_email'])?></p>
        <p><?=htmlspecialchars($info['admin_username'])?></p>

        <p>Role: Administrator</p>
        <p>Last Login: <?= date('d m y, h:i A');?></p>
    </div>