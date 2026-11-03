<?php
require_once "functions.php";
require_role("customer");
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: shop.php"); exit; }
$productId=(int)($_POST["product_id"]??0);
$quantity=filter_var($_POST["quantity"]??"",FILTER_VALIDATE_INT);
if(!$quantity || $quantity<1) { die("Invalid quantity. <a href='shop.php'>Return to shop</a>"); }

try {
    $pdo->beginTransaction();
    $stmt=$pdo->prepare("SELECT * FROM products WHERE id=? FOR UPDATE");
    $stmt->execute([$productId]);
    $product=$stmt->fetch();
    if(!$product || $product["quantity"]<$quantity) {
        throw new Exception("Product not found or insufficient stock.");
    }
    $subtotal=(float)$product["price"]*$quantity;
    $invoice="INV-".date("Ymd")."-".strtoupper(bin2hex(random_bytes(3)));
    $stmt=$pdo->prepare("INSERT INTO purchases(invoice_number,customer_id,total) VALUES(?,?,?)");
    $stmt->execute([$invoice,$_SESSION["user_id"],$subtotal]);
    $purchaseId=(int)$pdo->lastInsertId();
    $stmt=$pdo->prepare("INSERT INTO purchase_items(purchase_id,product_id,product_name,price,quantity,subtotal) VALUES(?,?,?,?,?,?)");
    $stmt->execute([$purchaseId,$productId,$product["product_name"],$product["price"],$quantity,$subtotal]);
    $stmt=$pdo->prepare("UPDATE products SET quantity=quantity-? WHERE id=?");
    $stmt->execute([$quantity,$productId]);
    $pdo->commit();
    header("Location: invoice.php?id=".$purchaseId);
    exit;
} catch(Exception $e) {
    if($pdo->inTransaction()) $pdo->rollBack();
    die(e($e->getMessage())." <a href='shop.php'>Return to shop</a>");
}
