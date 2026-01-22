<?php

include "../config/db.php";
include "../includes/header.php";


$result = $conn->query("SELECT * FROM products");
?>

<a href="add.php">+ Add Product</a>

<br><br>

<input type="text" id="searchBox" placeholder="Live search product or categories..">

<table border="1" style="border-collapse: collapse; margin-top:10px;">
    <thead>
        <tr>
            <th>Product</th>
            <th>Category</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="tableData">
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['product_name']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>

            <td style="color: <?= ($row['quantity'] <= 10) ? 'red' : 'inherit' ?>;
                       font-weight: <?= ($row['quantity'] <= 10) ? 'bold' : 'normal' ?>;">
                <?= htmlspecialchars($row['quantity']) ?>
            </td>

            <td><?= htmlspecialchars($row['price']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Edit</a> |
                <a href="delete.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Delete this product?')">Delete</a>
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

    fetch("search.php?q=" + encodeURIComponent(query))
        .then(res => res.text())
        .then(html => {
            tableBody.innerHTML = html;
        })
        .catch(err => console.error("Search error:", err));
});
</script>

<?php include "../includes/footer.php"; ?>
