<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

require_once "php/db_config.php";

$searchMode = false;
$searchResults = null;

if (isset($_GET['q']) && !empty($_GET['q'])) {
    $searchMode = true;

    $q = "%" . $conn->real_escape_string($_GET['q']) . "%";

    $stmt = $conn->prepare("
        SELECT post_id, title, content, image_path 
        FROM posts 
        WHERE status = 'approved'
        AND (title LIKE ? OR content LIKE ?)
        ORDER BY created_at DESC
    ");
    $stmt->bind_param("ss", $q, $q);
    $stmt->execute();
    $searchResults = $stmt->get_result();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bichy Blog</title>
  <link rel="icon" type="img/png" href="img/bichy_logo.webp">
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Playwrite+US+Trad+Guides&family=Quicksand:wght@300..700&display=swap"
    rel="stylesheet">
  <style>
    body {
      font-family: "Quicksand", sans-serif;
    }

    h1 {
      font-family: "Playwrite US Trad Guides", cursive;
    }

    h2 {
      font-family: "Oswald", sans-serif;
    }

    .link_underline {
        position: relative;
        display: inline-block;
        text-decoration: none;
        color: #131313; 
        font-family: "Libre Baskerville", serif; 
    }

    .link_underline::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: -2px; 
        width: 0%;
        height: 1px;
        background-color: #131313; 
        transition: width 0.3s ease;
    }

    .link_underline:hover::after {
        width: 100%;
    }
  </style>
</head>

<body class="bg-[#dadada] text-[#131313]">

  <nav class="fixed top-0 z-50 w-full border-b border-[#dadada] bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center justify-between gap-6">

      <div class="flex items-center gap-2">
        <a href="index.php">
          <img src="img/bichy_logo.webp" alt="bichy logo" class="w-12 h-12">
        </a>
        <h1 class="text-2xl font-semibold text-[#131313]">Bichy Media</h1>
      </div>

      <div class="hidden md:flex flex-1 overflow-hidden whitespace-nowrap">
        <p class="animate-marquee text-sm text-gray-500 font-medium">
          Unveiling hidden stories, rare findings, and curious perspectives — turn the page.
        </p>
      </div>

      <div class="flex items-center gap-3">

        <?php if (!$loggedIn): ?>
        <a href="login.php"
          class="border border-[#131313] px-4 py-1 text-sm hover:bg-[#131313] hover:text-white transition">
          Login
        </a>

        <a href="register.php"
          class="border border-[#131313] px-4 py-1 text-sm hover:bg-[#131313] hover:text-white transition">
          Register
        </a>
        <?php endif;?>
      </div>

    </div>
  </nav>

  <main
    class="mt-10 max-w-6xl mx-auto px-6 py-12 bg-[url('paper-texture.png')] bg-cover bg-center bg-fixed text-[#131313]">

    <section class="mb-16 border border-[#131313] shadow-[0_2px_4px_rgba(0,0,0,0.25)] bg-[#f4f1e8] p-6">
      <h2 class="text-3xl font-bold mb-2 tracking-wide" style="font-family: 'Playfair Display', serif;">Featured Story
        of the Week</h2>
      <p class="text-sm uppercase tracking-widest opacity-70 mb-4">— Bichy Editorial Selection —</p>
      <p class="text-lg leading-relaxed" style="font-family: 'Libre Baskerville', serif;">
        <span class="text-4xl float-left mr-2 leading-none" style="font-family: 'Playfair Display', serif;">I</span>
        n a world driven by fast media, slow storytelling still wins. Dive into narratives crafted with intention,
        style, and the timeless charm of vintage journalism.
      </p>
    </section>

<form method="GET" action="index.php" class="mb-12 flex items-center gap-3 border-b border-[#131313] pb-3">
  <i data-lucide="search" class="w-6 h-6 text-[#131313]"></i>
  <input type="text" name="q" placeholder="Search the archives..."
    class="w-full bg-transparent focus:outline-none text-lg font-medium"
    style="font-family:'Libre Baskerville', serif;" />
</form>


    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

      <div class="border-l-4 border-[#131313] pl-4 bg-[#f7f5ee] shadow-[0_1px_2px_rgba(0,0,0,0.25)] p-4">
        <div class="w-full h-48 bg-cover bg-center mb-4 border border-[#131313] shadow-inner sepia-[25%]"
          style="background-image:url('img/data-lore-2pjqyckgvko-unsplash.webp');"></div>
        <a href="timeless_media.php" class="link_underline"><h3 class="text-2xl font-semibold tracking-wide" style="font-family: 'Playfair Display', serif;">Timeless Media
                  </h3>
        </a>
        <p class="text-sm mt-2 opacity-80" style="font-family: 'Libre Baskerville', serif;">Stories crafted from a
          different era, retold with elegance.</p>
      </div>

      <div class="border-l-4 border-[#131313] pl-4 bg-[#f7f5ee] shadow-[0_1px_2px_rgba(0,0,0,0.25)] p-4">
        <div class="w-full h-48 bg-cover bg-center mb-4 border border-[#131313] shadow-inner sepia-[25%]"
          style="background-image:url('img/the-new-york-public-library-Tl5NVpScrjA-unsplash.webp');"></div>
        <a href="newYorkTimes.php" class="link_underline"><h3 class="text-2xl font-semibold tracking-wide" style="font-family: 'Playfair Display', serif;">Old New York
                             Times</h3>
        </a>
        <p class="text-sm mt-2 opacity-80" style="font-family: 'Libre Baskerville', serif;">Historical scenes and
          classic tales from the big city.</p>
      </div>

      <div class="border-l-4 border-[#131313] pl-4 bg-[#f7f5ee] shadow-[0_1px_2px_rgba(0,0,0,0.25)] p-4">
        <div class="w-full h-48 bg-cover bg-center mb-4 border border-[#131313] shadow-inner sepia-[25%]"
          style="background-image:url('img/prakriti-khajuria-jjQX3oPjhhQ-unsplash.webp');"></div>
        <a href="culturalEchoes.php" class="link_underline"><h3 class="text-2xl font-semibold tracking-wide" style="font-family: 'Playfair Display', serif;">Cultural Echoes
                                        </h3>
        </a>
        <p class="text-sm mt-2 opacity-80" style="font-family: 'Libre Baskerville', serif;">Deep dives into culture,
          history, and artistic thought.</p>
      </div>
    </section>

    <?php if ($searchMode): ?>
    <section class="mt-20">
  <h2 class="text-3xl font-bold mb-6" style="font-family:'Playfair Display', serif;">
    Search Results
  </h2>

  <?php if ($searchResults->num_rows === 0): ?>
      <p class="opacity-70" style="font-family:'Libre Baskerville', serif;">
        No results found for "<strong><?= htmlspecialchars($_GET['q']); ?></strong>"
      </p>
  <?php else: ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
      <?php while ($row = $searchResults->fetch_assoc()): ?>
        <a href="article.php?id=<?= $row['post_id']; ?>" 
           class="border-l-4 border-[#131313] pl-4 bg-[#f7f5ee] shadow p-4 block link_underline">

          <div class="w-full h-48 bg-cover bg-center mb-4 border border-[#131313]" 
               style="background-image:url('<?= $row['image_path']; ?>');"></div>

          <h3 class="text-xl font-semibold mb-2" style="font-family:'Playfair Display', serif;">
            <?= htmlspecialchars($row['title']); ?>
          </h3>

          <p class="text-sm opacity-80" style="font-family:'Libre Baskerville', serif;">
            <?= substr(strip_tags($row['content']), 0, 120); ?>...
          </p>

        </a>
      <?php endwhile; ?>
    </div>

  <?php endif; ?>

</section>
<?php endif; ?>


    <div class="my-16 flex justify-center">
      <div class="w-32 h-1 bg-[#131313]"></div>
    </div>

    <section class="mt-10 mb-20 flex justify-center">
      <div class="border-2 border-[#131313] px-6 py-3 bg-[#f4f1e8] shadow-[3px_3px_0_#131313] rotate-[-2deg]">
        <p class="text-sm tracking-widest font-semibold" style="font-family:'Oswald';">BICHY EDITORIAL • EST. 1925</p>
      </div>
    </section>

  </main>

  <?php include_once __DIR__ . '/php/footer.php';?>

  <script src="https://unpkg.com/lucide@latest"></script>
  <script>lucide.createIcons();</script>

  <style>
    @keyframes marquee {
      0% {
        transform: translateX(100%);
      }

      100% {
        transform: translateX(-100%);
      }
    }

    .animate-marquee {
      animation: marquee 15s linear infinite;
    }
    @keyframes scroll-images {
      0% {
        transform: translateX(0);
      }

      100% {
        transform: translateX(-50%);
      }
    }

    .animate-scroll-images {
      animation: scroll-images 30s linear infinite;
      display: flex;
      width: 200%;
    }
  </style>
</body>

</html>