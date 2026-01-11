<?php
include "../includes/auth.php";
include "../config/db.php";
include "../includes/header.php";


$result = $conn->query("SELECT * FROM products");
?>

<a href="add.php">+Add Product</a>

<br><br>

<form method="GET" action="search.php">
    <input type="text"
           name="q"
           placeholder="Search by product name or category"
           required>
    <button type="submit">Search</button>
</form>



<table border="1" style='border-collapse: collapse;'>
<tr>
<th>Product</th><th>Category</th><th>Qty</th><th>Price</th><th>Action</th>
</tr>

<?php while ($row = $result->fetch_assoc()): ?>
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
<?php endwhile; ?>
</table>

<?php include "../includes/footer.php"; ?>
