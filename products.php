<?php
include 'db.php';
$category = $_GET['category'] ?? 'All';

$sql = "SELECT * FROM products" . ($category != 'All' ? " WHERE category='$category'" : '');
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Products - <?php echo htmlspecialchars($category); ?></h2>
    <div class="products">
        <?php while($product = $result->fetch_assoc()): ?>
            <div class="product">
                <img src="images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h3><?php echo $product['name']; ?></h3>
                <p>$<?php echo $product['price']; ?></p>
                <a href="cart.php?action=add&product_id=<?php echo $product['product_id']; ?>">Add to Cart</a>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
