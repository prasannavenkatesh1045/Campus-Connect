<?php if (!isset($page_title)) $page_title = "Campus Connect"; ?>
<!doctype html>
<html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= h($page_title) ?> | Campus Connect</title>
<link rel="stylesheet" href="assets/style.css">
</head><body>
<header class="topbar"><a class="brand" href="index.php">Campus Connect</a>
<nav><a href="index.php">Events</a>
<?php if (!empty($_SESSION['user_id'])): ?>
<a href="my_registrations.php">My Registrations</a><a href="logout.php">Logout</a>
<?php elseif (!empty($_SESSION['admin_id'])): ?>
<a href="admin.php">Admin Dashboard</a><a href="logout.php">Logout</a>
<?php else: ?>
<a href="login.php">Student Login</a><a href="register.php">Register</a><a href="admin_login.php">Admin</a>
<?php endif; ?></nav></header><main class="container">
