<?php
session_start();
include "../config/db.php";

$error = "";
$success = "";

if (isset($_POST['signup'])) {

$username = trim($_POST['su_username']);
$password = trim($_POST['su_password']);

if (empty($username) || empty($password)) {
$error = "All fields are required";
} 
else 

{

$check = $conn->prepare("SELECT id FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
$error="Username already exists";
} 
else 
{
$hashed = hash("sha256", $password);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed);
$stmt->execute();
$success = "Account created.";
 }
 }
  }

if (isset($_POST['login'])) {

    $username = trim($_POST['li_username']);
    $password = trim($_POST['li_password']);

    if (empty($username) || empty($password)) {
        $error = "All fields are required";
    } else {

        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {

            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            if (hash("sha256", $password) === $hashed_password) {
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;

                header("Location: index.php");
                exit();
            } else {
                $error = "Invalid login";
            }

        } else {
            $error = "Invalid login";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login / Signup</title>
    <link rel="stylesheet" href="../assets/css/style.css">

<style>
body {
    background: linear-gradient(135deg, #2c3e50, #4ca1af);
    min-height: 100vh;
}

/* Center container */
.auth-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

/* Main card */
.auth-card {
    background: white;
    padding: 35px;
    border-radius: 12px;
    width: 820px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.25);
}

.auth-header {
    text-align: center;
    margin-bottom: 25px;
}

.auth-header h2 {
    margin-bottom: 5px;
}

/* Forms container */
.auth-forms {
    display: flex;
    gap: 30px;
}

/* Each form */
.auth-box {
    flex: 1;
}

.auth-box h3 {
    margin-bottom: 10px;
}

/* Messages */
.auth-message {
    text-align: center;
    margin-bottom: 15px;
}
</style>

</head>
<body>

<div class="auth-wrapper">

<div class="auth-card">

<div class="auth-header">
<h2>Inventory Management System</h2>
<p>Login or create an account to continue</p>
</div>

<?php if ($error): ?>
<p class="auth-message" style="color:red;">
<?= htmlspecialchars($error) ?>
</p>
<?php endif; ?>

<?php if ($success): ?>
<p class="auth-message" style="color:green;">
<?= htmlspecialchars($success) ?>
</p>
<?php endif; ?>

<div class="auth-forms">

<!-- LOGIN -->
<form method="POST" class="auth-box">
<h3>Login</h3>

Username
<input type="text" name="li_username" required>

Password
<input type="password" name="li_password" required>

<button type="submit" name="login">Login</button>
</form>

<!-- SIGNUP -->
<form method="POST" class="auth-box">
<h3>Create Account</h3>

Username
<input type="text" name="su_username" required>

Password
<input type="password" name="su_password" required>

<button type="submit" name="signup">Sign Up</button>
</form>

</div>

</div>
</div>

</body>
</html>


