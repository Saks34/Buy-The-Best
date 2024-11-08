<?php
session_start();
include 'db.php';

if (isset($_GET['add'])) {
    $product_id = $_GET['add'];
    
    // Fetch product details from the database to add to the cart
    $query = "SELECT product_id, product_name, price FROM products WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);

    if ($product) {
        // Initialize cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add product to cart session
        $product_id = $product['product_id'];
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'name' => $product['product_name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
    }
    
    // Redirect to cart page
    header("Location: cart.php");
    exit;
}

// Display cart contents
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    echo "<h2>Your Cart</h2>";
    echo "<table>";
    echo "<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>";

    $total_price = 0;
    foreach ($_SESSION['cart'] as $id => $product) {
        $line_total = $product['price'] * $product['quantity'];
        $total_price += $line_total;

        echo "<tr>";
        echo "<td>{$product['name']}</td>";
        echo "<td>\${$product['price']}</td>";
        echo "<td>{$product['quantity']}</td>";
        echo "<td>\$$line_total</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<p>Total Price: \$$total_price</p>";
    echo "<a href='checkout.php' class='btn'>Proceed to Checkout</a>";
} else {
    echo "<p>Your cart is empty.</p>";
}

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Your Cart</h2>
    <div class="cart">
        <?php foreach ($cart_items as $product_id => $quantity): ?>
            <?php
            $product = $conn->query("SELECT * FROM products WHERE product_id=$product_id")->fetch_assoc();
            ?>
            <div class="cart-item">
                <h3><?php echo $product['name']; ?></h3>
                <p>Quantity: <?php echo $quantity; ?></p>
                <p>Price: $<?php echo $product['price'] * $quantity; ?></p>
                <a href="cart.php?action=remove&product_id=<?php echo $product_id; ?>">Remove</a>
            </div>
        <?php endforeach; ?>
        <a href="checkout.php">Proceed to Checkout</a>
    </div>
</body>
</html>
