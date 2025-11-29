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

if (isset($_SESSION['admin_message'])) {
    $message = $_SESSION['admin_message'];
    unset($_SESSION['admin_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login • Bichy Blog</title>
  <link rel="icon" type="img/png" href="../img/bichy_logo.webp">
  <script src="https://cdn.tailwindcss.com"></script>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&family=Quicksand:wght@300..700&family=Libre+Baskerville:wght@400;700&display=swap"
    rel="stylesheet">

  <style>
    body {
      font-family: "Quicksand", sans-serif;
      background: #dadada url('img/paper-texture.png') center center fixed;
      background-size: cover;
    }

    h1,
    h2 {
      font-family: "Libre Baskerville", serif;
    }

    .login-card {
      background: #f4f1e8;
      border-left: 4px solid #131313;
      padding: 2rem;
      max-width: 400px;
      margin: auto;
      margin-top: 10vh;
      box-shadow: 3px 3px 0 #131313;
    }

    .login-card input {
      border: 1px solid #131313;
      padding: 0.5rem;
      width: 100%;
    }

    .login-card button {
      background: #131313;
      color: white;
      padding: 0.5rem 1rem;
      transition: background 0.3s;
    }

    .login-card button:hover {
      background: #333;
    }
  </style>
</head>

<body>

  <div class="login-card">
    <h1 class="text-2xl font-bold mb-4 text-center">Admin Login</h1>
    <p class="text-sm mb-6 text-center opacity-70">Access the Bichy Blog admin panel to manage content and users.</p>

    <form action="php/admin_login_process.php" method="POST" class="space-y-4">
      <div>
        <label for="adminEmail" class="block mb-1 text-sm">Email</label>
        <input type="email" id="adminEmail" name="email" placeholder="admin@example.com" required>
      </div>

      <div>
        <label for="adminPassword" class="block mb-1 text-sm">Password</label>
        <input type="password" id="adminPassword" name="password" placeholder="********" required>
      </div>

      <div class="flex justify-between items-center text-sm">
        <label>
          <input type="checkbox" name="remember"> Remember Me
        </label>
        <a href="#" class="hover:underline">Forgot Password?</a>
      </div>

      <div class="text-center">
        <button type="submit" class="mt-4 w-full">Login</button>
      </div>
    </form>

    <p class="text-xs text-center mt-6 opacity-70">© 2025 Bichy Blog — Vintage stories, timeless control.</p>
  </div>

  <?php include_once __DIR__ . '/../php/messageBox.php';?>
</body>

</html>