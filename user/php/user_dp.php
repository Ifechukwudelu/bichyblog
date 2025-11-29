<?php  
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

    require_once __DIR__ . '/../../php/db_config.php';

    if (!isset($user_id)) {
    $user_id = $_SESSION['user_id'] ?? null;
    }

    $dpPath = null;
    $dpQuery = $conn->prepare("SELECT user_dp FROM user_dp WHERE user_id = ? LIMIT 1");
    $dpQuery->bind_param("i", $user_id);
    $dpQuery->execute();
    $dpQuery->bind_result($dpPath);

    $dpQuery->fetch();
    $dpQuery->close();

?>

<section id="profile" class="tab-content card">
        <h2 class="text-2xl font-semibold mb-4">Profile Picture</h2>
        <div class="flex gap-6 items-center">
        <?php if (!empty($dpPath)): ?>
          <img src="user_img/<?= htmlspecialchars($dpPath)?>" alt="profile" class="w-32 h-32 border border-[#131313] shadow-md object-cover">
        <?php else: ?>
          <img src="../img/lady.webp" alt="Profile" class="w-32 h-32 border border-[#131313] shadow-md object-cover">
        <?php endif; ?>
          <form action="php/user_allformsprocess.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="form_type" value="dp">
            <label class="block mb-2">Upload New Picture</label>
            <input type="file" class="border border-[#131313] px-2 py-1 mb-2" name="user_dp">
            <button type="submit" class="bg-[#131313] hover:bg-gray-800 text-white px-4 py-1 text-sm">Update</button>
          </form>
        </div>
</section>


