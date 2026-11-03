<?php
require_once "config.php";
$accounts=[["System Employee","employee","employee@supermarket.test","employee123","employee"],["Demo Customer","customer","customer@supermarket.test","customer123","customer"]];
foreach($accounts as $a){$q=$pdo->prepare("SELECT id FROM users WHERE username=?");$q->execute([$a[1]]);$uid=$q->fetchColumn();
if(!$uid){$q=$pdo->prepare("INSERT INTO users(full_name,username,email,password,role) VALUES(?,?,?,?,?)");$q->execute([$a[0],$a[1],$a[2],password_hash($a[3],PASSWORD_DEFAULT),$a[4]]);$uid=(int)$pdo->lastInsertId();}
if($a[4]==="customer"){$q=$pdo->prepare("SELECT customer_id FROM customers WHERE user_id=?");$q->execute([$uid]);if(!$q->fetch())$pdo->prepare("INSERT INTO customers(user_id,phone,address) VALUES(?,?,?)")->execute([$uid,"","Demo address"]);}
else{$q=$pdo->prepare("SELECT employee_id FROM employees WHERE user_id=?");$q->execute([$uid]);if(!$q->fetch())$pdo->prepare("INSERT INTO employees(user_id,employee_number,department,phone) VALUES(?,?,?,?)")->execute([$uid,"EMP-DEMO-001","Administration",""]);}}
require_once "functions.php";page_header("Setup complete");echo '<h2>Setup completed</h2><p class="success">Demo accounts and profiles are ready. Delete setup.php after running it.</p><p>Employee: employee / employee123</p><p>Customer: customer / customer123</p><p>Local employee registration code: STAFF-2026. Change it in config.php before deployment.</p><a class="button" href="login.php">Go to login</a>';page_footer();
