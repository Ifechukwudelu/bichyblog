<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "php/db_config.php";

$loggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;


if (!isset($_GET['id'])) {
    die("Article not found.");
}

$post_id = intval($_GET['id']);

$stmt = $conn->prepare("
    SELECT posts.*, users.name AS author_name,
           user_dp.user_dp AS author_image
    FROM posts 
    LEFT JOIN users ON posts.user_id = users.user_id
    LEFT JOIN user_dp ON posts.user_id = user_dp.user_id
    WHERE post_id = ?
    LIMIT 1
");

$stmt->bind_param("i", $post_id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    die("Article not found.");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Reader • Bichy Blog</title>
    <link rel="icon" type="img/png" href="img/bichy_logo.webp">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Playwrite+US+Trad+Guides&family=Quicksand:wght@300..700&family=Libre+Baskerville:wght@400;700&family=Dancing+Script&display=swap"
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

        .torn-paper {
            clip-path: polygon(0 0, 100% 0, 100% 85%, 95% 90%, 90% 85%, 85% 90%,
                    80% 85%, 75% 90%, 70% 85%, 65% 90%, 60% 85%,
                    55% 90%, 50% 85%, 45% 90%, 40% 85%, 35% 90%,
                    30% 85%, 25% 90%, 20% 85%, 15% 90%, 10% 85%,
                    5% 90%, 0 85%);
        }

        .grain {
            background-image: url('https://grainy-gradients.vercel.app/noise.svg');
            opacity: 0.2;
            pointer-events: none;
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

        .print-edition {
            column-count: 2;
            column-gap: 3rem;
        }

        .author-signature {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
        }

        .toc {
            position: sticky;
            top: 80px;
            max-height: calc(100vh - 100px);
            overflow-y: auto;
            padding: 1rem;
            background: #f7f5ee;
            border: 1px solid #131313;
        }

        .toc a {
            display: block;
            padding: 0.25rem 0;
            font-size: 0.9rem;
            color: #131313;
            text-decoration: none;
        }

        .toc a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body class="bg-[#dadada] text-[#131313] relative">

    <div class="grain fixed inset-0 z-[-1]"></div>

    <nav class="fixed top-0 z-50 w-full border-b border-[#131313] bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a href="index.php"><img src="img/bichy_logo.webp" class="w-12 h-12" /></a>
                <h1 class="text-2xl font-bold tracking-wide">Bichy Media</h1>
            </div>
            <div class="flex items-center gap-4">
                <input type="text" placeholder="Search..."
                    class="border border-[#131313] px-2 py-1 text-sm bg-[#f7f5ee] focus:outline-none">
                <?php if(!$loggedIn): ?>
                <a href="#" class="px-3 py-1 bg-[#131313] text-white text-sm hover:bg-gray-800">Login</a>
                <a href="#" class="px-3 py-1 bg-[#131313] text-white text-sm hover:bg-gray-800">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <main class="pt-28 max-w-6xl mx-auto px-6 flex gap-6">

        <div class="flex-1">

            <a href="timeless_media.php" class="text-sm underline opacity-70 hover:opacity-100">← Back to archives</a>

            <h1 class="text-4xl font-bold torn-paper bg-[#f4f1e8] p-6 border border-[#131313] shadow-sm mt-6">
              <?= htmlspecialchars($post['title']); ?>
            </h1>


            <div class="w-full h-80 bg-cover bg-center mt-8 border border-[#131313] shadow-inner sepia"
                style="background-image:url('<?= htmlspecialchars($post['image_path']); ?>')"></div>

            <article class="mt-10 bg-[#f7f5ee] p-8 border border-[#131313] shadow-sm leading-loose text-md">
                <?= nl2br($post['content']); ?>
            </article>

            <div class="mt-12 flex items-center gap-4 bg-[#f4f1e8] border border-[#131313] p-6 shadow-sm">
                <img src="<?= !empty($post['author_image']) ? $post['author_image'] : 'img/lady.webp'; ?>" 
                class="w-20 h-20 rounded-full border border-[#131313]"
                alt="Author">

                <div>
                    <p class="font-semibold">By <?= htmlspecialchars($post['author_name'] ?? "Unknown Author"); ?></p>

                    <p class="text-sm opacity-80 mt-1">
                        Jane is a historian and journalist passionate about preserving the elegance of classic
                        storytelling. She brings old eras to life with a modern lens.
                    </p>
                    <p class="author-signature mt-2">~ <?= htmlspecialchars($post['author_name'] ?? "Unknown Author"); ?></p>
                </div>
            </div>

            <div class="mt-12 flex justify-between items-center">
                <a href="#" class="px-4 py-2 border border-[#131313] bg-[#f4f1e8] shadow hover:bg-[#ece9df]">← Previous
                    Story</a>
                <a href="#" class="px-4 py-2 border border-[#131313] bg-[#f4f1e8] shadow hover:bg-[#ece9df]">Next Story
                    →</a>
            </div>

            <div class="mt-20 mb-20 flex justify-center">
                <div class="border-2 border-[#131313] px-6 py-3 bg-[#f4f1e8] shadow-[3px_3px_0_#131313] rotate-[-2deg]">
                    <p class="text-sm tracking-widest font-bold" style="font-family:'Oswald';">
                        BICHY ARCHIVES • EST. 1925
                    </p>
                </div>
            </div>

        </div>
    </main>

    <?php include_once __DIR__ . '/php/footer.php';?>

</body>

</html>