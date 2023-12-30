<?php
include 'dbcon.php';

$alertClass = "";
$alertMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle signup form submission
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $name = $_POST['name'];
    $number = $_POST['number'];

    // Perform SQL query to insert user into the database
    $sql = "INSERT INTO users (name,email, number, password) VALUES ('$name','$email','$number', '$password')";

    if ($password != $confirmPassword) {
         $alertClass = "alert-danger";
         $alertMessage = "Passwords do not match.";
         header("location: login.php?alertClass=$alertClass&alertMessage=$alertMessage");
        exit();
    } else if ($conn->query($sql) === TRUE) {
        $alertClass = "alert-success";
        $alertMessage = "SuccesFully Registered.";
        header("location: login.php?alertClass=$alertClass&alertMessage=$alertMessage");
        exit();

    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>