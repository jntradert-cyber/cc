<?php
require_once "functions.php";
require_role("customer");
$stmt=$pdo->prepare("SELECT * FROM purchases WHERE customer_id=? ORDER BY purchased_at DESC");
$stmt->execute([$_SESSION["user_id"]]);
$rows=$stmt->fetchAll();
page_header("My purchases");
?>
<h2>My purchases</h2>
<table><tr><th>Invoice</th><th>Date</th><th>Total</th><th>View</th></tr>
<?php foreach($rows as $r): ?><tr><td><?=e($r["invoice_number"])?></td><td><?=e($r["purchased_at"])?></td><td><?=money($r["total"])?></td><td><a href="invoice.php?id=<?=$r["id"]?>">Open invoice</a></td></tr><?php endforeach; ?>
</table>
<?php if(!$rows): ?><p>You have not made any purchases yet.</p><?php endif; ?>
<?php page_footer(); ?>
