



NO AJAX ADDED YET BTW.







<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include "../config/db.php";

$error = "";
$success = "";

if (isset($_POST['signup'])) {

    $username = trim($_POST['su_username']);
    $password = trim($_POST['su_password']);

    if (empty($username) || empty($password)) {
        $error = "All signup fields are required";
    } else {

        $check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $check->bind_param("s", $username);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Username already exists";
        } else {
            // Hash password
            $hashed = hash("sha256", $password);

            // Insert user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);
            $stmt->execute();

            $success = "Account created. You can now login.";
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Login / Signup</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>Inventory System - Login & Signup</h2>

<?php if ($error): ?>
<p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if ($success): ?>
<p style="color:green;"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

<!-- LOGIN FORM -->
<form method="POST">

<h3>Login</h3>

Username
<input type="text" name="li_username" required>

Password
<input type="password" name="li_password" required>

<button type="submit" name="login">Login</button>
</form>
<br>


<form method="POST">

<h3>Signup</h3>

Username
<input type="text" name="su_username" required>

Password
<input type="password" name="su_password" required>

<button type="submit" name="signup">Create Account</button>

</form>

</body>
</html>
