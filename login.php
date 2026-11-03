<?php
require_once "functions.php";
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $password = $_POST["password"] ?? "";
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["full_name"] = $user["full_name"];
        $_SESSION["role"] = $user["role"];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
page_header("Login");
?>
<h2>Login</h2><?php if(isset($_GET["registered"])): ?><p class="success">Registration successful. You can now log in.</p><?php endif; ?>
<?php if ($error): ?><p class="error"><?=e($error)?></p><?php endif; ?>
<form method="post">
<label>Username</label><input name="username" required>
<label>Password</label><input type="password" name="password" required>
<button type="submit">Login</button>
</form>
<p>New user? <a href="register.php">Create an account</a> | <a href="home.php">Home</a></p><p>Demo employee: employee / employee123</p>
<p>Demo customer: customer / customer123</p>
<?php page_footer(); ?>
