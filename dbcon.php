<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; 
$dbpassword = ""; 
$dbname = "sleekstyle"; 

// Create a new connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>