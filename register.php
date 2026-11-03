<?php
require_once "functions.php";
if(!empty($_SESSION["user_id"])){header("Location: dashboard.php");exit;}
$error=""; $role=$_GET["role"]??"customer";
if(!in_array($role,["customer","employee"],true))$role="customer";
if($_SERVER["REQUEST_METHOD"]==="POST"){
$name=trim($_POST["full_name"]??"");$username=trim($_POST["username"]??"");$email=trim($_POST["email"]??"");$phone=trim($_POST["phone"]??"");$password=$_POST["password"]??"";$confirm=$_POST["confirm_password"]??"";$role=$_POST["role"]??"customer";$address=trim($_POST["address"]??"");$department=trim($_POST["department"]??"");$code=trim($_POST["employee_code"]??"");
if(!in_array($role,["customer","employee"],true))$error="Choose a valid account type.";
elseif($name===""||$username===""||!filter_var($email,FILTER_VALIDATE_EMAIL))$error="Enter your name, username and valid email.";
elseif(strlen($password)<6)$error="Password must have at least 6 characters.";
elseif($password!==$confirm)$error="Passwords do not match.";
elseif($role==="employee"&&$code!==EMPLOYEE_REGISTRATION_CODE)$error="Incorrect employee code. Contact the administrator.";
else{try{$pdo->beginTransaction();$q=$pdo->prepare("INSERT INTO users(full_name,username,email,password,role) VALUES(?,?,?,?,?)");$q->execute([$name,$username,$email,password_hash($password,PASSWORD_DEFAULT),$role]);$uid=(int)$pdo->lastInsertId();
if($role==="customer"){$q=$pdo->prepare("INSERT INTO customers(user_id,phone,address) VALUES(?,?,?)");$q->execute([$uid,$phone,$address]);}
else{$number="EMP-".date("ymd")."-".strtoupper(bin2hex(random_bytes(2)));$q=$pdo->prepare("INSERT INTO employees(user_id,employee_number,department,phone) VALUES(?,?,?,?)");$q->execute([$uid,$number,$department,$phone]);}
$pdo->commit();header("Location: login.php?registered=1");exit;
}catch(PDOException $ex){if($pdo->inTransaction())$pdo->rollBack();$error="Registration failed. Username or email may already exist.";}}}
page_header("Register");?>
<h2>Create an account</h2><p>Choose the account type that matches your role.</p>
<?php if($error):?><p class="error"><?=e($error)?></p><?php endif;?>
<form method="post"><label>Account type</label><select name="role" id="role" onchange="toggleFields()"><option value="customer" <?=$role==="customer"?"selected":""?>>Customer</option><option value="employee" <?=$role==="employee"?"selected":""?>>Employee</option></select>
<label>Full name</label><input name="full_name" required><label>Username</label><input name="username" required><label>Email</label><input type="email" name="email" required><label>Phone</label><input name="phone">
<div id="customerFields"><label>Address</label><input name="address"></div><div id="employeeFields"><label>Department</label><input name="department" placeholder="Sales or Inventory"><label>Employee registration code</label><input type="password" name="employee_code"><p class="muted">Ask the system administrator for this code.</p></div>
<label>Password (minimum 6 characters)</label><input type="password" name="password" minlength="6" required><label>Confirm password</label><input type="password" name="confirm_password" minlength="6" required><button type="submit">Register</button></form>
<p>Already registered? <a href="login.php">Login here</a>.</p>
<script>function toggleFields(){let emp=document.getElementById('role').value==='employee';document.getElementById('employeeFields').style.display=emp?'block':'none';document.getElementById('customerFields').style.display=emp?'none':'block';}toggleFields();</script>
<?php page_footer(); ?>
