<?php
require_once "functions.php";
require_login();
page_header("Dashboard");
?>
<h2>Welcome, <?=e($_SESSION["full_name"])?></h2>
<p>You are logged in as <b><?=e($_SESSION["role"])?></b>.</p>
<?php if ($_SESSION["role"] === "employee"): ?>
<div class="card"><h3>Employee dashboard</h3><p>Add products and monitor stock levels.</p>
<a class="button" href="add_product.php">Add product</a> <a class="button" href="inventory.php">View inventory</a></div>
<?php else: ?>
<div class="card"><h3>Customer dashboard</h3><p>Browse available products, purchase items and view invoices.</p>
<a class="button" href="shop.php">Start shopping</a> <a class="button" href="my_purchases.php">My purchases</a></div>
<?php endif; ?>
<?php page_footer(); ?>
