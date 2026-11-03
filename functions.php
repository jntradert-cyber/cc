<?php
require_once "config.php";
function e($v){return htmlspecialchars((string)$v,ENT_QUOTES,"UTF-8");}
function require_login(){if(empty($_SESSION["user_id"])){header("Location: login.php");exit;}}
function require_role($role){require_login();if($_SESSION["role"]!==$role){header("Location: dashboard.php");exit;}}
function money($v){return "RWF ".number_format((float)$v,2);}
function page_header($title="Supermarket System"){
echo '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>'.e($title).'</title><link rel="stylesheet" href="style.css"></head><body><header><h1>Supermarket Information System</h1><nav><a href="home.php">Home</a> ';
if(!empty($_SESSION["user_id"])){echo '<a href="dashboard.php">Dashboard</a> ';if($_SESSION["role"]==="employee")echo '<a href="add_product.php">Add product</a> <a href="inventory.php">Inventory</a> ';else echo '<a href="shop.php">Shop</a> <a href="my_purchases.php">My purchases</a> ';echo '<a href="change_password.php">Change password</a> <a href="logout.php">Logout</a>';}
else echo '<a href="login.php">Login</a> <a href="register.php">Register</a>';
echo '</nav></header><main>';
}
function page_footer(){echo '</main><footer><p>&copy; '.date("Y").' Supermarket Information System</p></footer></body></html>';}
