<?php
include "../includes/auth.php";
include "../config/db.php";
include "../includes/header.php";

// Check if search query exists
if (!isset($_GET['q']) || empty($_GET['q'])) {
    echo "<p>No search term provided.</p>";
    include "../includes/footer.php";
    exit();
}

// Get search value safely
$search = $conn->real_escape_string($_GET['q']);

// SQL query
$sql = "SELECT * FROM products 
        WHERE product_name LIKE '%$search%' 
        OR category LIKE '%$search%'";

$result = $conn->query($sql);
?>

<a href="index.php">← Back to Products</a>
<br><br>

<h3>Search Results for: <?= htmlspecialchars($search) ?></h3>

<table border="1" style="border-collapse: collapse;">
<tr>
<th>Product</th><th>Category</th><th>Qty</th><th>Price</th><th>Action</th>
</tr>

<?php
if ($result->num_rows>0):
    while ($row = $result->fetch_assoc()):
?>
<tr>
<td><?= htmlspecialchars($row['product_name']) ?></td>
<td><?= htmlspecialchars($row['category']) ?></td>
<td><?= $row['quantity'] ?></td>
<td><?= $row['price'] ?></td>
<td>
<a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?')">Delete</a>
</td>
</tr>
<?php
    endwhile;
else:
?>
<tr>
<td colspan="5">No products found</td>
</tr>
<?php endif; ?>
</table>

<?php include "../includes/footer.php"; ?>
