<?php
require_once "functions.php";
require_role("customer");
$id=(int)($_GET["id"]??0);
$stmt=$pdo->prepare("SELECT * FROM purchases WHERE id=? AND customer_id=?");
$stmt->execute([$id,$_SESSION["user_id"]]);
$purchase=$stmt->fetch();
if(!$purchase){http_response_code(404);die("Invoice not found.");}
$stmt=$pdo->prepare("SELECT * FROM purchase_items WHERE purchase_id=?");
$stmt->execute([$id]);
$items=$stmt->fetchAll();
page_header("Invoice");
?>
<div class="invoice">
<h2>SUPERMARKET INVOICE</h2>
<p><b>Invoice number:</b> <?=e($purchase["invoice_number"])?></p>
<p><b>Customer:</b> <?=e($_SESSION["full_name"])?></p>
<p><b>Date:</b> <?=e($purchase["purchased_at"])?></p>
<table><tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
<?php foreach($items as $item): ?><tr><td><?=e($item["product_name"])?></td><td><?=money($item["price"])?></td><td><?=$item["quantity"]?></td><td><?=money($item["subtotal"])?></td></tr><?php endforeach; ?>
</table>
<h3>Total: <?=money($purchase["total"])?></h3>
<button onclick="window.print()">Print invoice</button>
</div>
<?php page_footer(); ?>
