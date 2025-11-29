<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../php/db_config.php';


             $totalUsers = $conn->query("SELECT user_id FROM users")->num_rows;
             $pendingPosts = $conn->query("SELECT post_id FROM posts WHERE status='pending'")->num_rows;
             $approvedPosts = $conn->query("SELECT post_id FROM posts WHERE status='approved'")->num_rows;
 ?>
 
        <div class="flex-1 p-8">

        <div id="overview" class="tab-content active">
                <h2 class="text-3xl font-bold mb-4">Dashboard Overview</h2>
                <p class="mb-6">Welcome to the Bichy Blog admin panel. Here you can manage users, moderate posts, and
                    maintain
                    the timeless vintage charm of our stories.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-4 border-l-4 border-[#131313] bg-[#f4f1e8] shadow-sm">
                        <h3 class="font-semibold mb-2">Total Users</h3>
                        <p><?=htmlspecialchars($totalUsers)?></p>
                    </div>
                    <div class="p-4 border-l-4 border-[#131313] bg-[#f4f1e8] shadow-sm">
                        <h3 class="font-semibold mb-2">Pending Posts</h3>
                        <p><?=htmlspecialchars($pendingPosts)?></p>
                    </div>
                    <div class="p-4 border-l-4 border-[#131313] bg-[#f4f1e8] shadow-sm">
                        <h3 class="font-semibold mb-2">Approved Posts</h3>
                        <p><?=htmlspecialchars($approvedPosts)?></p>
                    </div>
                </div>
            </div>