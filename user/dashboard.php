<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user_id = $_SESSION['user_id'] ?? null;
include_once __DIR__ . '/../php/auth_check.php';

$message = "";
$redirectAfter = "";

if (isset($_SESSION['redirect_after'])) {
    $redirectAfter = $_SESSION['redirect_after'];
    unset($_SESSION['redirect_after']);
}

if (isset($_SESSION['user_message'])) {
    $message = $_SESSION['user_message'];
    unset($_SESSION['user_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard • Bichy Blog</title>
  <link rel="icon" type="img/png" href="../img/bichy_logo.webp">
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Playwrite+US+Trad+Guides&family=Quicksand:wght@300..700&family=Libre+Baskerville:wght@400;700&display=swap"
    rel="stylesheet">

  <style>
    body {
      font-family: "Quicksand", sans-serif;
      background: #dadada url('../img/paper-texture.png') center center fixed;
      background-size: cover;
    }

    h1 {
      font-family: "Playwrite US Trad Guides", cursive;
    }

    h2,
    h3 {
      font-family: "Libre Baskerville", serif;
    }

    .tab-content {
      display: none;
    }

    .tab-active {
      display: block;
    }

    .sidebar {
      background: #f7f5ee;
      border-right: 2px solid #131313;
    }

    .card {
      background: #f4f1e8;
      border-left: 4px solid #131313;
      padding: 1rem;
      box-shadow: 2px 2px 0 #131313;
    }
  </style>
</head>

<body>

  <nav class="fixed top-0 z-50 w-full border-b border-[#131313] bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
      <div class="flex items-center gap-2">
        <a href="../index.php"><img src="../img/bichy_logo.webp" class="w-12 h-12" /></a>
        <h1 class="text-2xl font-bold">Bichy Blog</h1>
      </div>
      <a href="../logout.php"
        class="px-3 py-1 border border-[#131313] text-sm hover:bg-[#131313] hover:text-white">Logout</a>
    </div>
  </nav>

  <div class="pt-20 flex max-w-7xl mx-auto px-4 gap-6">

    <aside class="sidebar w-64 p-4 flex flex-col gap-4">
      <h2 class="text-xl font-bold mb-4">Dashboard</h2>
      <button onclick="showTab('overview')"
        class="text-left px-3 py-2 w-full hover:bg-[#dadada] transition">Overview</button>
      <button onclick="showTab('profile')" class="text-left px-3 py-2 w-full hover:bg-[#dadada] transition">Profile
        Picture</button>
      <button onclick="showTab('details')" class="text-left px-3 py-2 w-full hover:bg-[#dadada] transition">Personal
        Details</button>
      <button onclick="showTab('post')" class="text-left px-3 py-2 w-full hover:bg-[#dadada] transition">Post
        Article</button>
    </aside>

    <main class="flex-1 flex flex-col gap-6">

      <section id="overview" class="tab-content tab-active card">
        <h2 class="text-2xl font-semibold mb-2">Welcome Back!</h2>
        <p class="text-sm opacity-80 leading-relaxed">
          Here you can manage your profile, view your activity, and submit articles to Bichy Blog. Keep our
          timeless stories alive!
        </p>
      </section>

      <?php include_once __DIR__ . '/php/user_dp.php';?>
      <?php include_once __DIR__ . '/php/user_info.php';?>
      <?php include_once __DIR__ . '/php/user_post.php';?>
      

    </main>
  </div>

  <footer class="bg-[#131313] text-[#dadada] mt-16 border-t border-[#dadada] py-12">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-10">

      <div class="flex flex-col items-center md:items-start gap-3">
        <img src="../img/prakriti-khajuria-jjQX3oPjhhQ-unsplash.webp"
          class="w-32 h-32 object-cover border-2 border-[#dadada] shadow-md" />
        <h2 class="text-xl font-semibold tracking-wide" style="font-family: 'Playwrite US Trad Guides';">Bichy
          Blog</h2>
        <p class="text-sm opacity-80">Old-fashioned stories. Timeless vibes.</p>
      </div>

      <div class="flex flex-col items-center md:items-start">
        <h3 class="text-lg font-semibold mb-2" style="font-family: 'Oswald';">Our Location</h3>
        <p class="text-sm opacity-80 mb-3">Bichy Publishing House<br>14th Street, Manhattan<br>New York City,
          USA</p>

        <div class="w-48 h-32 border border-[#dadada] bg-cover bg-center shadow-md"
          style="background-image: url('../img/the-new-york-public-library-fd4xuoOojNc-unsplash.webp'); filter: grayscale(100%);">
        </div>
        <p class="text-xs mt-2 opacity-70">Vintage New York map (illustrative)</p>
      </div>

      <div class="flex flex-col items-center md:items-start">
        <h3 class="text-lg font-semibold mb-2" style="font-family: 'Oswald';">Explore</h3>
        <ul class="text-sm space-y-2 opacity-90">
          <li><a href="#" class="hover:underline">About Us</a></li>
          <li><a href="#" class="hover:underline">Contact</a></li>
          <li><a href="#" class="hover:underline">Editorial Team</a></li>
          <li><a href="#" class="hover:underline">Privacy Policy</a></li>
        </ul>
      </div>

    </div>

    <div class="border-t border-[#dadada] mt-10 pt-4 text-center text-xs opacity-70">
      © 2025 Bichy Blog — Crafted with style & storytelling.
    </div>
  </footer>

  <script>
    function showTab(tabId) {
      document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('tab-active'));
      document.getElementById(tabId).classList.add('tab-active');

      document.querySelectorAll('#post .tab-content').forEach(el => el.classList.remove('tab-active'));
      if (tabId === 'post') document.getElementById('timeless').classList.add('tab-active');
    }

    function showPostTab(tabId) {
      document.querySelectorAll('#post .tab-content').forEach(el => el.classList.remove('tab-active'));
      document.getElementById(tabId).classList.add('tab-active');
    }
  </script>
<?php include_once __DIR__ . '/../php/messageBox.php';?>
</body>

</html>