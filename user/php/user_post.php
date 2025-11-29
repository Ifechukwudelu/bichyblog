      <?php
          if (session_status() === PHP_SESSION_NONE) {
          session_start();
          }
          require_once __DIR__ . '/../../php/db_config.php';
          require_once __DIR__ . '/user_info.php';

        if (!isset($user_id)) {
        $user_id = $_SESSION['user_id'] ?? null;
        }
    ?>

      
      <section id="post" class="tab-content card">
        <h2 class="text-2xl font-semibold mb-4">Post a New Article</h2>

        <div class="flex gap-2 mb-4">
          <button onclick="showPostTab('timeless')"
            class="px-3 py-1 border border-[#131313] text-sm hover:bg-[#dadada] transition">Timeless Media</button>
          <button onclick="showPostTab('oldny')"
            class="px-3 py-1 border border-[#131313] text-sm hover:bg-[#dadada] transition">Old New York Times</button>
          <button onclick="showPostTab('cultural')"
            class="px-3 py-1 border border-[#131313] text-sm hover:bg-[#dadada] transition">Cultural Echoes</button>
        </div>

        <div id="timeless" class="tab-content tab-active">
          <p class="text-sm opacity-80 mb-2">Share stories crafted from a different era, elegance and depth.</p>
          <form action="php/user_allformsprocess.php" method="POST" enctype="multipart/form-data" class="space-y-3">
            <input type="hidden" name="form_type" value="post_article">
            <input type="hidden" name="category" value="timeless">  
            <input type="text" name="title" placeholder="Article Title" class="w-full border border-[#131313] px-2 py-1">
            <textarea name="content" placeholder="Write your article..."
              class="w-full border border-[#131313] px-2 py-1 h-32"></textarea>
            <input type="text" value="<?= htmlspecialchars($userInfo['name'])?> | <?= htmlspecialchars($userInfo['role'])?> " class="w-full border-b border-[#131313] px-2 py-1" readonly>
            <input type="file" name="article_image" class="border border-[#131313] px-2 py-1">
            <button type="submit" class="bg-[#131313] hover:bg-gray-800 text-white px-4 py-1 text-sm">Post</button>
          </form>
        </div>

        <div id="oldny" class="tab-content">
          <p class="text-sm opacity-80 mb-2">Historical scenes and classic tales from the big city.</p>
          <form action="php/user_allformsprocess.php" method="POST" enctype="multipart/form-data" class="space-y-3">
            <input type="hidden" name="form_type" value="post_article">
            <input type="hidden" name="category" value="oldNewYork">  
            <input type="text" name="title" placeholder="Article Title" class="w-full border border-[#131313] px-2 py-1">
            <textarea name="content" placeholder="Write your article..."
              class="w-full border border-[#131313] px-2 py-1 h-32"></textarea>
            <input type="text" value="<?= htmlspecialchars($userInfo['name'])?> | <?= htmlspecialchars($userInfo['role'])?> " class="w-full border-b border-[#131313] px-2 py-1" readonly>
            <input type="file" name="article_image" class="border border-[#131313] px-2 py-1">
            <button type="submit" class="bg-[#131313] hover:bg-gray-800 text-white px-4 py-1 text-sm">Post</button>
          </form>
        </div>

        <div id="cultural" class="tab-content">
          <p class="text-sm opacity-80 mb-2">Deep dives into culture, history, and artistic thought.</p>
          <form action="php/user_allformsprocess.php" method="POST" enctype="multipart/form-data" class="space-y-3">
            <input type="hidden" name="form_type" value="post_article">
            <input type="hidden" name="category" value="cultural">  
            <input type="text" name="title" placeholder="Article Title" class="w-full border border-[#131313] px-2 py-1">
            <textarea name="content" placeholder="Write your article..."
              class="w-full border border-[#131313] px-2 py-1 h-32"></textarea>
            <input type="text" value="<?= htmlspecialchars($userInfo['name'])?> | <?= htmlspecialchars($userInfo['role'])?> " class="w-full border-b border-[#131313] px-2 py-1" readonly>
            <input type="file" name="article_image" class="border border-[#131313] px-2 py-1">
            <button type="submit" class="bg-[#131313] hover:bg-gray-800 text-white px-4 py-1 text-sm">Post</button>
          </form>
        </div>

      </section>