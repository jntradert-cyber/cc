<?php
require_once "functions.php";
require_login();
$message=""; $error="";
if($_SERVER["REQUEST_METHOD"]==="POST"){
    $old=$_POST["old_password"]??"";
    $new=$_POST["new_password"]??"";
    $confirm=$_POST["confirm_password"]??"";
    $stmt=$pdo->prepare("SELECT password FROM users WHERE id=?");
    $stmt->execute([$_SESSION["user_id"]]);
    $current=$stmt->fetchColumn();
    if(!password_verify($old,$current)) $error="Current password is incorrect.";
    elseif(strlen($new)<6) $error="New password must contain at least 6 characters.";
    elseif($new!==$confirm) $error="New passwords do not match.";
    else {
        $hash=password_hash($new,PASSWORD_DEFAULT);
        $stmt=$pdo->prepare("UPDATE users SET password=? WHERE id=?");
        $stmt->execute([$hash,$_SESSION["user_id"]]);
        $message="Password changed successfully.";
    }
}
page_header("Change password");
?>
<h2>Change password</h2>
<?php if($error): ?><p class="error"><?=e($error)?></p><?php endif; ?>
<?php if($message): ?><p class="success"><?=e($message)?></p><?php endif; ?>
<form method="post">
<label>Current password</label><input type="password" name="old_password" required>
<label>New password</label><input type="password" name="new_password" required>
<label>Confirm new password</label><input type="password" name="confirm_password" required>
<button type="submit">Change password</button>
</form>
<?php page_footer(); ?>
