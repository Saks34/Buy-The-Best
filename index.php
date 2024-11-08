<?php
include 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy The Best - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Welcome to Buy The Best</h1>
        <nav>
            <a href="products.php?category=All">All Products</a>
            <a href="login.php">Login</a>
            <a href="signup.php">Signup</a>
            <a href="cart.php">Cart</a>
        </nav>
    </header>

    <main>
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php
            // Fetch products from the database
            $query = "SELECT image_path AS image, product_name AS name, price, product_id FROM products";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '
                        <div class="product">
                            <img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">
                            <h3>' . htmlspecialchars($row['name']) . '</h3>
                            <span>$' . htmlspecialchars($row['price']) . '</span>
                            <a href="cart.php?add=' . htmlspecialchars($row['product_id']) . '" class="btn">Add to Cart</a>
                        </div>
                    ';
                }
            } else {
                echo "<p>No products found.</p>";
            }

            mysqli_close($conn);
            ?>
        </div>
    </main>
</body>
</html>
