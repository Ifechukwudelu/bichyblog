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
    <title>Timeless Media • Bichy Blog</title>
    <link rel="icon" type="img/png" href="img/bichy_logo.webp">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Playwrite+US+Trad+Guides&family=Quicksand:wght@300..700&family=Libre+Baskerville:wght@400;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: "Quicksand", sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: "Libre Baskerville", serif;
        }

        .typewriter {
            overflow: hidden;
            white-space: nowrap;
            border-right: 2px solid #131313;
            animation: typing 4s steps(40, end), blink .75s step-end infinite;
        }

        @keyframes typing {
            from {
                width: 0
            }

            to {
                width: 100%
            }
        }

        @keyframes blink {
            50% {
                border-color: transparent
            }
        }
    </style>
</head>

<body class="bg-[#dadada] text-[#131313]">

    <nav class="fixed top-0 z-50 w-full border-b border-[#131313] bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between py-3">
            <div class="flex items-center gap-2">
                <a href="index.php"><img src="img/bichy_logo.webp" class="w-12 h-12" /></a>
                <h1 class="text-2xl font-bold tracking-wide">Timeless Media</h1>
            </div>
            <div class="flex items-center gap-4">
                <form method="GET" action="timeless_media.php">
                <input type="text" name="q" placeholder="Search archives..."
                    class="border border-[#131313] px-2 py-1 text-sm focus:outline-none bg-[#f7f5ee]" />
                </form>

                <?php if(!$loggedIn): ?>
                <a href="login.php" class="px-3 py-1 bg-[#131313] text-white text-sm hover:bg-gray-800">Login</a>
                <a href="register.php" class="px-3 py-1 bg-[#131313] text-white text-sm hover:bg-gray-800">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="pt-28 max-w-6xl mx-auto px-6">

        <section class="mb-12 text-center">
            <h2 class="text-4xl font-bold typewriter">Stories Crafted From a Different Era</h2>
            <p class="mt-2 text-sm opacity-70 tracking-widest uppercase">— Bichy Vintage Archives —</p>
        </section>

        <div class="w-full h-72 bg-cover bg-center border border-[#131313] shadow-inner mb-12 sepia-[30%]"
            style="background-image:url('img/data-lore-2pjqyckgvko-unsplash.webp')"></div>

        <section class="mb-16 bg-[#f7f5ee] p-6 border border-[#131313] shadow-sm leading-loose">
            <p class="text-lg" style="font-family:'Libre Baskerville', serif;">
                Timeless Media preserves the elegance of old-fashioned storytelling — narratives written with depth,
                intention, and the calm rhythm that defined classic journalism. Here, every story feels like a page
                from a treasured archive.
            </p>
        </section>

        <?php
        require_once "php/db_config.php";

        $query = "SELECT post_id, title, content, image_path FROM posts 
                    WHERE status = 'approved' AND category = 'timeless'
                    ORDER BY created_at DESC";

        $result = $conn->query($query);
        ?>

        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="border-l-4 border-[#131313] pl-4 bg-[#f4f1e8] p-4 shadow-sm">

                <div class="w-full h-48 bg-cover bg-center mb-4 border border-[#131313] sepia"
            style="background-image:url('<?= htmlspecialchars($row['image_path']); ?>')"></div>

                <a href="article.php?id=<?= $row['post_id']; ?>">
                    <h3 class="text-xl font-semibold">
                        <?= htmlspecialchars($row['title']); ?>
                    </h3>
                </a>

                <p class="text-sm opacity-80 mt-1">
                    <?= substr(strip_tags($row['content']), 0, 120); ?>...
                </p>
            </div>
        <?php endwhile; ?>
        </section>

        <?php if ($searchMode): ?>
    <section class="mt-10">
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


        <section class="mt-20 mb-20 flex justify-center">
            <div class="border-2 border-[#131313] px-6 py-3 bg-[#f4f1e8] shadow-[3px_3px_0_#131313] rotate-[-2deg]">
                <p class="text-sm tracking-widest font-bold" style="font-family:'Oswald';">BICHY ARCHIVES • EST. 1925
                </p>
            </div>
        </section>

    </main>

    <?php include_once __DIR__ . '/php/footer.php';?>

</body>

</html>