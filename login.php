<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login • Bichy Blog</title>
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

        h1 {
            font-family: "Playwrite US Trad Guides", cursive;
        }
        h2,
        h3 {
            font-family: "Libre Baskerville", serif;
        }

        .form-container {
            max-width: 450px;
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
                    Welcome back! Log in to continue sharing your stories.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="register.php"
                    class="border border-[#131313] px-4 py-1 text-sm hover:bg-[#131313] hover:text-white transition">
                    Register
                </a>
            </div>

        </div>
    </nav>

    <section class="pt-28 max-w-6xl mx-auto px-6 mb-12">
        <div
            class="border-l-4 border-[#131313] pl-4 bg-[#f4f1e8] shadow-md p-6 flex flex-col md:flex-row items-center gap-4">
            <div class="flex-1">
                <h2 class="text-2xl font-semibold mb-2">Welcome Back, Creatives</h2>
                <p class="text-sm opacity-80">
                    Log in to Bichy Blog to submit articles, share stories, and collaborate with fellow editors and
                    storytellers. Your contributions keep the timeless tales alive.
                </p>
            </div>
            <div class="flex-1 w-full md:w-48 h-32 bg-cover bg-center border border-[#131313] sepia"
                style="background-image: url('img/navy-medicine-nIUvLmPTER4-unsplash.webp');"></div>
        </div>
    </section>

    <main class="flex justify-center items-start px-4">
        <div class="form-container bg-[#f7f5ee] border border-[#131313] shadow-md p-8 rounded-lg">

            <h2 class="text-2xl font-bold mb-4 text-center" style="font-family: 'Libre Baskerville', serif;">Login</h2>
            <p class="text-sm opacity-70 text-center mb-6">Access your account to submit articles and join the Bichy
                Blog community.</p>

            <form action="user/php/user_login_process.php" method="POST" class="space-y-4">

                <div>
                    <label for="username" class="block text-sm font-medium mb-1">Username or Email</label>
                    <input type="text" id="username" name="username" required
                        class="w-full border border-[#131313] px-3 py-2 focus:outline-none focus:border-gray-500 rounded" />
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full border border-[#131313] px-3 py-2 focus:outline-none focus:border-gray-500 rounded" />
                </div>

                <div class="text-center mt-4">
                    <button type="submit"
                        class="bg-[#131313] hover:bg-gray-800 text-white px-6 py-2 rounded text-sm font-medium transition">
                        Login
                    </button>
                </div>

            </form>

            <p class="text-xs opacity-70 mt-6 text-center">Don't have an account? <a href="register.php"
                    class="underline hover:text-[#131313]">Register here</a>.</p>

        </div>
    </main>

    <?php include_once __DIR__ . '/php/footer.php';?>

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
    </style>
<?php include_once __DIR__ . '/php/messageBox.php';?>
</body>

</html>