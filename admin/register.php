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
  <title>Admin Registration • Bichy Blog</title>
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
      background: #dadada url('../img/paper-texture.png') center center fixed;
      background-size: cover;
    }

    h1,
    h2 {
      font-family: "Libre Baskerville", serif;
    }

    .form-container {
      max-width: 500px;
      margin: 5rem auto;
      padding: 2rem;
      background: #f4f1e8;
      border-left: 4px solid #131313;
      box-shadow: 3px 3px 0 #131313;
    }

    input {
      width: 100%;
      padding: 0.5rem 0.75rem;
      margin-bottom: 1rem;
      border: 1px solid #131313;
      background: #f7f5ee;
      font-family: 'Quicksand', sans-serif;
    }

    button {
      background: #131313;
      color: white;
      padding: 0.5rem 1rem;
      font-size: 1rem;
      width: 100%;
      transition: 0.2s;
    }

    button:hover {
      background: #333;
    }

    .top-banner {
      text-align: center;
      margin-bottom: 2rem;
    }

    .top-banner img {
      width: 80px;
      height: 80px;
      margin-bottom: 0.5rem;
    }
  </style>
</head>

<body>

  <div class="form-container">
    <div class="top-banner">
      <img src="../img/bichy_logo.webp" alt="Bichy Logo">
      <h1 class="text-2xl font-bold">Admin Registration</h1>
      <p class="text-sm opacity-70">Join the Bichy Blog admin team</p>
    </div>

    <form action="php/admin_register_process.php" method="POST">
      <label for="fullname">Full Name</label>
      <input type="text" name="fullname" id="fullname" placeholder="John Doe" class="m-2 ml-0 px-3 py-2" required>

      <label for="email">Email</label>
      <input type="email" name="email" id="email" placeholder="admin@example.com" class="m-2 ml-0 px-3 py-2" required>

      <label for="username">Username</label>
      <input type="text" name="username" id="username" placeholder="admin123" class="m-2 ml-0 px-3 py-2" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" placeholder="********" class="m-2 ml-0 px-3 py-2" required>

      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" id="confirm_password" placeholder="********"
        class="m-2 ml-0 px-3 py-2" required>

      <button type="submit">Register</button>
    </form>

    <p class="text-center text-sm opacity-70 mt-4">
      Already have an admin account? <a href="login.php" class="underline hover:text-[#131313]">Login here</a>
    </p>
  </div>


  <?php include_once __DIR__ . '/../php/messageBox.php';?>
</body>

</html>