<?php
// Include PHPMailer and exceptions
session_start();

// Assuming you have a login process and the user is authenticated
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to fetch user from the database (replace with actual query)
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        // Fetch user details
        $user = mysqli_fetch_assoc($result);
        
        // Store the email and name in the session
        $_SESSION['customer_email'] = $user['email'];
        $_SESSION['customer_name'] = $user['name']; // Assuming 'name' is a column in the users table
        
        // Redirect to the checkout page
        header("Location: checkout.php");
        exit();
    } else {
        echo "Invalid credentials.";
    }
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Your database code to insert order goes here
    
    // Send email confirmation after order is placed successfully
    try {
        $mail = new PHPMailer(true); // Create a new PHPMailer instance

        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;
        $mail->Username   = 'sakshamsatnalika34@gmail.com'; // Your Gmail address
        $mail->Password   = 'sztd zoyz cthf xoka';  // Your Gmail password (or App password if 2FA enabled)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        //Recipients
        $mail->setFrom('sakshamsatnalika34@gmail.com', 'Buy The Best');
        $mail->addAddress($customerEmail, $customerName);  // Customer's email address

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Confirmation - Order #' . $orderID;
        $mail->Body    = "Hello $customerName,<br><br>Thank you for your order! Your order ID is $orderID. We will process it soon.<br><br>Best Regards,<br>Buy The Best Team";

        // Send the email
        $mail->send();
        echo 'Order confirmation email has been sent.';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Checkout Page</h1>
    </header>

    <main>
        <h2>Order Confirmation</h2>
        <form method="POST">
            <p>Your order has been successfully placed. A confirmation email will be sent shortly.</p>
            <button type="submit">Place Order</button>
        </form>
    </main>

    <footer>
        <p>Buy The Best - Your online store</p>
    </footer>
</body>
</html>
