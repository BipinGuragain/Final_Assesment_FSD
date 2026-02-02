<?php

include "../includes/auth.php";
include "../config/db.php";
include "../includes/functions.php";

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


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_name= trim($_POST['product_name']);
    $category= trim($_POST['category']);
    $quantity= sanitizeQuantity($_POST['quantity']);
    $price= sanitizePrice($_POST['price']);

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

<div style="display:flex; justify-content:center;">
<div style="width:450px;">

<h2>Edit Product</h2>

<form method="POST" onsubmit="return confirmEdit();">

<label>Product Name</label>
<input type="text" name="product_name"
       value="<?= htmlspecialchars($product['product_name']) ?>" required>

<label>Category</label>
<input type="text" name="category"
       value="<?= htmlspecialchars($product['category']) ?>" required>

<label>Quantity</label>
<input type="number" name="quantity" min="0"
       value="<?= htmlspecialchars($product['quantity']) ?>" required>

<label>Price</label>
<input type="number" name="price" step="0.01" min="0"
       value="<?= htmlspecialchars($product['price']) ?>" required>

<button type="submit">Update Product</button>
<a href="index.php" style="margin-left:10px;">Cancel</a>

</form>

</div>
</div>

<script>
function confirmEdit() {
    return confirm("Update this product?");
}
</script>

<?php include "../includes/footer.php"; ?>
