<?php
include 'db.php';

// Retrieve form data with checks
$product_name = $_POST['product_name'] ?? '';
$category = $_POST['category'] ?? '';
$price = $_POST['price'] ?? 0;
$stock = $_POST['stock'] ?? 0;

// Handle file upload with additional checks
$target_dir = "images/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);  // Create the images folder if it doesn't exist
}

if (isset($_FILES["product_image"]["name"]) && $_FILES["product_image"]["error"] === 0) {
    $target_file = $target_dir . basename($_FILES["product_image"]["name"]);
    if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["product_image"]["name"]) . " has been uploaded.<br>";
    } else {
        echo "Error: Could not upload the file. Check permissions and path.<br>";
        $target_file = '';  // Set as empty if file upload fails
    }
} else {
    echo "No file selected or file upload error.<br>";
    $target_file = '';  // Default path if no file is uploaded
}

// Insert data into the database
$image_path = $target_file;
$query = "INSERT INTO products (product_name, category, price, stock, image_path) 
          VALUES ('$product_name', '$category', '$price', '$stock', '$image_path')";

if (mysqli_query($conn, $query)) {
    echo "Product added successfully.<br>";
} else {
    echo "Database Error: " . mysqli_error($conn) . "<br>";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Buy The Best</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Add New Product</h1>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="product_name" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" id="category" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" name="price" id="price" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" name="stock" id="stock" required>
            </div>

            <div class="form-group">
                <label for="product_image">Product Image:</label>
                <input type="file" name="product_image" id="product_image" required>
            </div>

            <button type="submit">Add Product</button>
        </form>
    </div>
</body>
</html>
