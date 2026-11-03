<?php
require_once "functions.php";
require_role("employee");
$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["product_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = filter_var($_POST["price"] ?? "", FILTER_VALIDATE_FLOAT);
    $quantity = filter_var($_POST["quantity"] ?? "", FILTER_VALIDATE_INT);
    if ($name !== "" && $price !== false && $price >= 0 && $quantity !== false && $quantity >= 0) {
        $stmt = $pdo->prepare("INSERT INTO products(product_name,description,price,quantity) VALUES(?,?,?,?)");
        $stmt->execute([$name,$description,$price,$quantity]);
        $message = "Product added successfully.";
    } else {
        $message = "Please enter a valid product name, price and quantity.";
    }
}
page_header("Add product");
?>
<h2>Add a new product</h2>
<?php if ($message): ?><p class="success"><?=e($message)?></p><?php endif; ?>
<form method="post">
<label>Product name</label><input name="product_name" required>
<label>Description</label><textarea name="description"></textarea>
<label>Price (RWF)</label><input type="number" name="price" min="0" step="0.01" required>
<label>Quantity in stock</label><input type="number" name="quantity" min="0" required>
<button type="submit">Save product</button>
</form>
<?php page_footer(); ?>
