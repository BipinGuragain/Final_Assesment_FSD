<?php
include "../includes/auth.php";
include "../config/db.php";


$q = isset($_GET['q']) ? trim($_GET['q']) : "";


$stmt = $conn->prepare(
"SELECT id, product_name, category, quantity, price 
FROM products 
WHERE product_name LIKE ? 
OR category LIKE ?"
);

$search= "%" .$q ."%";
$stmt->bind_param("ss", $search, $search);
$stmt->execute();


$stmt->bind_result($id, $product_name, $category, $quantity, $price);


$found = false;

while ($stmt->fetch())
{
$found= true;
echo "<tr>";
echo "<td>" .htmlspecialchars($product_name) ."</td>";
echo "<td>" .htmlspecialchars($category) ."</td>";
$color = ($quantity <= 10) ? "red" :"inherit";
$weight = ($quantity <= 10)? "bold" :"normal";

echo "<td style='color:$color; font-weight:$weight;'>$quantity</td>";

echo "<td>Rs. ".htmlspecialchars($price) . "</td>";
echo "<td>";
echo "<a href='edit.php?id=" .$id ."'>Edit</a> | ";
echo "<a href='delete.php?id=" .$id . "' onclick=\"return confirm('Delete this product?')\">Delete</a>";
echo "</td>";
echo "</tr>";
}

if (!$found) {
echo "<tr><td colspan='5'>No products found</td></tr>";
}
?>
