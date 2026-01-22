<?php
include "../config/db.php";
include "../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_name = trim($_POST["product_name"]);
    $category     = trim($_POST["category"]);
    $quantity     = sanitizeQuantity($_POST["quantity"]);
    $price        = sanitizePrice($_POST["price"]);

    $stmt = $conn->prepare(
        "INSERT INTO products (product_name, category, quantity, price)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param(
        "ssid",
        $product_name,
        $category,
        $quantity,
        $price
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}

include "../includes/header.php";
?>

<form method="POST">

    <label>Product Name</label>
    <input type="text" name="product_name" required>

    <label>Category</label>
    <input type="text" name="category" required>

    <label>Quantity</label>
    <input type="number" name="quantity" min="0" required>

    <label>Price</label>
    <input type="number" name="price" step="0.01" min="0" required>

    <button type="submit">Save Product</button>
</form>

<?php include "../includes/footer.php"; ?>
