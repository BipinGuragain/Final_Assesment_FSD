<?php

include "../config/db.php";
include "../includes/functions.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $qty = sanitizeQuantity($_POST['quantity']);

    $stmt = $conn->prepare(
        "INSERT INTO products (product_name, category, quantity, price)
         VALUES (?,?,?,?)"
    );
    $stmt->bind_param(
        "ssid",
        $_POST['product_name'],
        $_POST['category'],
        $qty,
        $_POST['price']
    );
    $stmt->execute();

}
include "../includes/header.php";
?>

<form method="POST">
    Product Name:<br>
    <input type="text" name="product_name" required><br><br>

    Category:<br>
    <input type="text" name="category" required><br><br>

    Quantity:<br>
    <input type="number" min="0" name="quantity" required><br><br>

    Price:<br>
    <input type="number" step="0.01" name="price" required><br><br>

    <button type="submit">Save Product</button>
</form>

<?php include "../includes/footer.php"; ?>
