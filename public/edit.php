<?php

include "../config/db.php";
include "../includes/functions.php";

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID");
}

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Product not found");
}

$product = $result->fetch_assoc();

// ================== UPDATE PRODUCT ==================
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_name = trim($_POST['product_name']);
    $category     = trim($_POST['category']);
    $quantity     = sanitizeQuantity($_POST['quantity']);
    $price        = (float)$_POST['price'];

    $stmt = $conn->prepare(
        "UPDATE products
         SET product_name = ?, category = ?, quantity = ?, price = ?
         WHERE id = ?"
    );

    $stmt->bind_param(
        "ssidi",
        $product_name,
        $category,
        $quantity,
        $price,
        $id
    );

    $stmt->execute();

    header("Location: index.php");
    exit;
}

include "../includes/header.php";
?>

<h2>Edit Product</h2>

<form method="POST" onsubmit="return confirmEdit();">

    <label for="product_name">Product Name</label>
    <input type="text"
           id="product_name"
           name="product_name"
           value="<?= htmlspecialchars($product['product_name']) ?>"
           required>

    <label for="category">Category</label>
    <input type="text"
           id="category"
           name="category"
           value="<?= htmlspecialchars($product['category']) ?>"
           required>

    <label for="quantity">Quantity</label>
    <input type="number"
           id="quantity"
           name="quantity"
           min="0"
           value="<?= htmlspecialchars($product['quantity']) ?>"
           required>

    <label for="price">Price</label>
    <input type="number"
           id="price"
           name="price"
           step="0.01"
           value="<?= htmlspecialchars($product['price']) ?>"
           required>

    <button type="submit">Update Product</button>
    <a href="index.php" style="margin-left:10px;">Cancel</a>
</form>

<script>
function confirmEdit() {
    return confirm("Are you sure you want to update this product?");
}
</script>

<?php include "../includes/footer.php"; ?>
