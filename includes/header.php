<!DOCTYPE html>
<html>
<head>
    <title>Inventory System</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<h2>📦Inventory & Stock Tracking System | GARIO👞 </h2>
<?php if (isset($_SESSION['username'])): ?>
<p>
Logged in as <b><?= htmlspecialchars($_SESSION['username']) ?></b>
<a href="logout.php">Logout</a>
</p>
<?php endif; ?>
<hr>
