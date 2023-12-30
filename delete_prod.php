<?php
session_start();
include 'dbcon.php';

    $prod_id = $_GET['id'];
    $user = $_SESSION['user_email'];

    // Perform the deletion query
    $deleteQuery = "DELETE FROM cart WHERE user_email = '$user' AND prod_id = $prod_id";
    if (mysqli_query($conn, $deleteQuery)) {
       header("location: shopping-cart.php");
    } else {
        echo "Error deleting product: " . mysqli_error($your_db_connection);
    }
?>
