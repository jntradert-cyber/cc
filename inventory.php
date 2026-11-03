<?php
require_once "functions.php";
require_role("employee");
$perPage = 5;
$page = max(1, (int)($_GET["page"] ?? 1));
$total = (int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$pages = max(1, (int)ceil($total/$perPage));
$page = min($page,$pages);
$stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT :lim OFFSET :off");
$stmt->bindValue(":lim",$perPage,PDO::PARAM_INT);
$stmt->bindValue(":off",($page-1)*$perPage,PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll();
page_header("Inventory");
?>
<h2>Inventory status</h2>
<p>Total products: <?= $total ?></p>
<table><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Status</th></tr>
<?php foreach($products as $p): ?>
<tr><td><?=e($p["product_name"])?></td><td><?=money($p["price"])?></td><td><?=$p["quantity"]?></td>
<td><?=$p["quantity"] > 0 ? "In stock" : "Out of stock"?></td></tr>
<?php endforeach; ?>
</table>
<div class="pagination">
<?php for($i=1;$i<=$pages;$i++): ?><a href="?page=<?=$i?>"><?=$i?></a><?php endfor; ?>
</div>
<?php page_footer(); ?>
