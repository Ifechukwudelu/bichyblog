<?php 

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header("Location: login.php");
    exit();
}

$message = "";
$redirectAfter = "";

if (isset($_SESSION['admin_message'])) {
    $message = $_SESSION['admin_message'];
    unset($_SESSION['admin_message']);
}

if (isset($_SESSION['redirect_after'])) {
    $redirectAfter = $_SESSION['redirect_after'];
    unset($_SESSION['redirect_after']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard • Bichy Blog</title>
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
        h2,
        h3 {
            font-family: "Libre Baskerville", serif;
        }

        .sidebar {
            background: #f4f1e8;
            border-right: 4px solid #131313;
            min-height: 100vh;
            padding: 2rem 1rem;
            box-shadow: 3px 0 0 #131313;
        }

        .sidebar a {
            display: block;
            padding: 0.5rem 1rem;
            margin: 0.25rem 0;
            border-left: 3px solid transparent;
            transition: all 0.2s;
        }

        .sidebar a.active,
        .sidebar a:hover {
            border-left: 3px solid #131313;
            background: #e0ddd3;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #f7f5ee;
        }

        th,
        td {
            border: 1px solid #131313;
            padding: 0.5rem 1rem;
            text-align: left;
        }

        th {
            background: #e0ddd3;
        }

        button {
            background: #131313;
            color: white;
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            transition: 0.2s;
        }

        button:hover {
            background: #333;
        }
        
    </style>
</head>

<body>
    <button id="menuBtn" class="md:hidden px-3 py-1 border border-[#131313]">
     ☰ Menu
    </button>
    <div class="flex">
        <div id="sidebar" class="sidebar w-64 fixed md:static top-0 left-0 h-full md:h-auto
        md:translate-x-0 -translate-x-full transition-transform duration-300 z-40">
            
            <h1 class="text-2xl font-bold mb-6 text-center">Bichy Admin</h1>
            <a href="#" class="tab-link active" data-tab="overview">Overview</a>
            <a href="#" class="tab-link" data-tab="users">Users</a>
            <a href="#" class="tab-link" data-tab="posts">Posts</a>
            <a href="#" class="tab-link" data-tab="profile">Profile</a>
            <a href="admin_logout.php">Log out</a>
        </div>
        <div id="overlay" class="fixed inset-0 bg-black/40 hidden md:hidden z-30"></div>

           
            <?php include_once __DIR__ . '/php/admin_overview.php';?>
            <?php include_once __DIR__ . '/php/admin_viewusers.php';?>
            <?php include_once __DIR__ . '/php/posts_table.php';?>
            <?php include_once __DIR__ . '/php/admin_info.php';?>
    </div>

    <script>
       const menuBtn = document.getElementById("menuBtn");
          const sidebar = document.getElementById("sidebar");
          const overlay = document.getElementById("overlay");

          menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
          });

          overlay.addEventListener("click", () => {
            sidebar.classList.add("-translate-x-full");
            overlay.classList.add("hidden");
          });

        const tabLinks = document.querySelectorAll('.tab-link');
        const tabContents = document.querySelectorAll('.tab-content');

        tabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                tabLinks.forEach(l => l.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                link.classList.add('active');
                document.getElementById(link.dataset.tab).classList.add('active');
            });
        });

        const userRoleTabs = document.querySelectorAll('.user-role-tab');
        const userRows = document.querySelectorAll('#user-tbody tr');

        userRoleTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                userRoleTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const role = tab.dataset.role;
                userRows.forEach(row => {
                    row.style.display = (row.dataset.role === role) ? '' : 'none';
                });
            });
        });

        const postCategoryTabs = document.querySelectorAll('.post-category-tab');
        const postRows = document.querySelectorAll('#post-tbody tr');

        postCategoryTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                postCategoryTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const category = tab.dataset.category;
                postRows.forEach(row => {
                    row.style.display = (row.dataset.category === category) ? '' : 'none';
                });
            });
        });
    </script>
  <?php include_once __DIR__ . '/../php/messageBox.php';?>
</body>

</html>
