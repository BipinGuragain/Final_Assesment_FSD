<?php
include "../includes/auth.php";
include "../config/db.php";
include "../includes/header.php";

$result = $conn->query("SELECT * FROM products");
?>

<div style="display:flex; justify-content:space-between; align-items:center;">

<div>
<a href="add.php">
<button>+ Add Product</button>
</a>
</div>

<input type="text" id="searchBox"
       placeholder="Search products or categories...">

</div>

<table>

<thead>
<tr>
<th>Product</th>
<th>Category</th>
<th>Quantity</th>
<th>Price</th>
<th>Action</th>
</tr>
</thead>

<tbody id="tableData">

<?php while ($row = $result->fetch_assoc()): ?>
<tr>

<td><?= htmlspecialchars($row['product_name']) ?></td>

<td><?= htmlspecialchars($row['category']) ?></td>

<td style="
color: <?= ($row['quantity'] <= 10) ? 'red' : 'inherit' ?>;
font-weight: <?= ($row['quantity'] <= 10) ? 'bold' : 'normal' ?>;
">
<?= htmlspecialchars($row['quantity']) ?>
</td>

<td>Rs. <?= htmlspecialchars($row['price']) ?></td>

<td>
<a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
<a href="delete.php?id=<?= $row['id'] ?>"
   onclick="return confirm('Delete this product?')">
Delete
</a>
</td>

</tr>
<?php endwhile; ?>

</tbody>
</table>

<script>
const searchBox = document.getElementById("searchBox");
const tableBody = document.getElementById("tableData");

searchBox.addEventListener("keyup", function () {
    const query = this.value;

    fetch("search.php?q="+encodeURIComponent(query))
        .then(res => res.text())
        .then(html => tableBody.innerHTML = html)
        .catch(err => console.error(err));
});
</script>

<?php include "../includes/footer.php"; ?>
