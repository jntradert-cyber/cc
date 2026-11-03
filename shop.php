<?php
require_once "functions.php";
require_role("customer");
$perPage=6;
$page=max(1,(int)($_GET["page"]??1));
$total=(int)$pdo->query("SELECT COUNT(*) FROM products WHERE quantity>0")->fetchColumn();
$pages=max(1,(int)ceil($total/$perPage));
$page=min($page,$pages);
$stmt=$pdo->prepare("SELECT * FROM products WHERE quantity>0 ORDER BY product_name LIMIT :lim OFFSET :off");
$stmt->bindValue(":lim",$perPage,PDO::PARAM_INT);
$stmt->bindValue(":off",($page-1)*$perPage,PDO::PARAM_INT);
$stmt->execute();
$products=$stmt->fetchAll();
page_header("Shop");
?>
<h2>Available products</h2>
<?php if(!$products): ?><p>No products are currently available.</p><?php endif; ?>
<table><tr><th>Product</th><th>Description</th><th>Price</th><th>Available</th><th>Buy</th></tr>
<?php foreach($products as $p): ?>
<tr><td><?=e($p["product_name"])?></td><td><?=e($p["description"])?></td><td><?=money($p["price"])?></td><td><?=$p["quantity"]?></td>
<td><form method="post" action="purchase.php"><input type="hidden" name="product_id" value="<?=$p["id"]?>">
<label>Quantity</label><input type="number" name="quantity" min="1" max="<?=$p["quantity"]?>" value="1" required>
<button type="submit">Purchase</button></form></td></tr>
<?php endforeach; ?>
</table>
<div class="pagination"><?php for($i=1;$i<=$pages;$i++): ?><a href="?page=<?=$i?>"><?=$i?></a><?php endfor; ?></div>
<?php page_footer(); ?>
