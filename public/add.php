<?php
include "../includes/auth.php";
include "../config/db.php";
include "../includes/functions.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

if (
!isset($_POST['csrf_token']) ||
$_POST['csrf_token'] !== $_SESSION['csrf_token']
) {
   die("Invalid CSRF token");
    }
$product_name= trim($_POST["product_name"]);
$category= trim($_POST["category"]);
$quantity= sanitizeQuantity($_POST["quantity"]);
$price= sanitizePrice($_POST["price"]);

$stmt = $conn->prepare(
        "INSERT INTO products (product_name, category, quantity, price)
         VALUES (?, ?, ?, ?)"
);

$stmt->bind_param("ssid",
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

<div style="display:flex; justify-content:center;">
<div style="width:450px;">

<h2>Add New Product</h2>

<form method="POST">

<input type="hidden" name="csrf_token"
value="<?= $_SESSION['csrf_token'];?>">

<label>Product Name</label>
<input type="text" name="product_name"required>

<label>Category</label>
<input type="text" name="category"required>

<label>Quantity</label>
<input type="number" name="quantity" min="0"required>

<label>Price</label>
<input type="number" name="price" step="0.01"min="0"required>

<button type="submit">Save Product</button>
<a href= "index.php" style="margin-left: 10px;">Cancel</a>
</form>

</div>
</div>

<?php include "../includes/footer.php"; ?>
