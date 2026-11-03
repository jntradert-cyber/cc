<?php require_once "functions.php"; page_header("Welcome"); ?>
<section class="hero"><p class="eyebrow">WELCOME TO YOUR LOCAL SHOPPING PARTNER</p><h2>Everything you need, in one place.</h2><p>Shop everyday essentials, check product availability and keep purchases organized.</p><a class="button" href="register.php">Create an account</a> <a class="button secondary" href="login.php">Login</a></section>
<h2>Why use our supermarket system?</h2><div class="benefits">
<article class="card"><h3>Easy shopping</h3><p>Browse available products and purchase online.</p></article>
<article class="card"><h3>Clear invoices</h3><p>View and print an invoice after every successful purchase.</p></article>
<article class="card"><h3>Account security</h3><p>Personal accounts with securely hashed passwords.</p></article>
<article class="card"><h3>Stock monitoring</h3><p>Employees can add products and monitor inventory.</p></article></div>
<h2>Benefits of registering</h2><div class="benefits">
<article class="card"><h3>Customer account</h3><ul><li>Browse products in stock.</li><li>Purchase products online.</li><li>Receive and print invoices.</li><li>Review purchase history.</li><li>Change password.</li></ul><a href="register.php?role=customer">Register as customer</a></article>
<article class="card"><h3>Employee account</h3><ul><li>Add new products.</li><li>View inventory status.</li><li>Monitor stock quantities.</li><li>Change password.</li><li>Use employee dashboard.</li></ul><a href="register.php?role=employee">Register as employee</a><p class="muted">Requires an authorized staff code.</p></article></div>
<?php page_footer(); ?>
