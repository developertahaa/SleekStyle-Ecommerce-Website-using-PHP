<?php
include '../dbcon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Retrieve form values
    $Name = $_POST['name'];
    $category = $_POST['category'];
    $label = $_POST['label'];
    $desc = $_POST['desc'];
    $price = $_POST['price'];
    $rating = $_POST['rating'];

    // Use the correct number of placeholders in the query
    $insertQuery = $conn->prepare("INSERT INTO products (name, category, label, description, price, rating) VALUES (?, ?, ?, ?, ?, ?)");
    $insertQuery->bind_param("ssssdd", $Name, $category, $label, $desc, $price, $rating);

    $insertQuery->execute();
    $insertQuery->close();

    header("Location: add_product.php?confirmation=true");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete = $conn->prepare("DELETE FROM products WHERE id = ?");
    $delete->bind_param("s", $id);
    
    $delete->execute();
    $delete->close();
    header("Location: add_product.php?deletion=true");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['admin'])) {
    $Name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
  

    // Use the correct number of placeholders in the query
    $insertQuery = $conn->prepare("INSERT INTO admin (username, email, password) VALUES (?, ?, ?)");
    $insertQuery->bind_param("sss", $Name, $email, $password);

    $insertQuery->execute();
    $insertQuery->close();

    header("Location: profile.php?confirmation=true");
    exit();
}

?>
