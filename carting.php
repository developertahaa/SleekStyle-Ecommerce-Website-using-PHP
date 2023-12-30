<?php
include 'dbcon.php';
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: index.php?alert=true");
    exit; // Make sure to stop the script execution after the redirect
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quan = $_POST['quan'];
    $prod_id = $_POST['prod_id'];
    $email = $_SESSION['user_email'];
    $size = $_POST['size'];

    // Fetch the price from the products table
    $fetchQuery = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $fetchQuery->bind_param("i", $prod_id);
    $fetchQuery->execute();
    $fetchResult = $fetchQuery->get_result();
    
    // Check if the product exists
    if ($fetchResult->num_rows > 0) {
        $row = $fetchResult->fetch_assoc();
        $price = $row['price'];

        // Calculate the total price
        $t_price = $price * $quan;

        // Insert into the cart table
        $insertQuery = $conn->prepare("INSERT INTO cart (prod_id, quantity, user_email, t_price, size) VALUES (?, ?, ?, ?, ?)");
        $insertQuery->bind_param("iisds", $prod_id, $quan, $email, $t_price, $size);

        if ($insertQuery->execute()) {
            // Redirect to shopping-cart.php with the correct product ID
            header("Location: shopping-cart.php?id=" . $prod_id);
            exit();
        } else {
            echo "Error: " . $insertQuery->error;
        }

        $insertQuery->close();
    } else {
        echo "Product not found.";
    }

    $fetchQuery->close();
    $conn->close();
}
?>
