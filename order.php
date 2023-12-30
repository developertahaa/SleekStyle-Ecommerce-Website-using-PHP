<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
include 'dbcon.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form values
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $country = $_POST['country'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $orderNotes = $_POST['order_notes'];
    $paymentMethod = "COD";
    $user_email = $_SESSION['user_email'];
    $coupon = $_SESSION['coupon_code'];
    $discount = $_SESSION['discount'];
    $status = 'confirmed';
    $fetchQuery = $conn->prepare("SELECT products.id, products.name, cart.quantity, cart.t_price 
                                FROM cart 
                                JOIN products ON cart.prod_id = products.id 
                                WHERE cart.user_email = ?");
    $fetchQuery->bind_param("s", $user_email);
    $fetchQuery->execute();
    $result = $fetchQuery->get_result();

    $productIds = [];
    $orderTotal = 0;

    while ($row = $result->fetch_assoc()) {
        $productId = $row['id'];
        $quantity = $row['quantity'];
        $totalPrice = $row['t_price'];

        // Store product ID in an array
        $productIds[] = $productId;

        // Add the product total to the order total
        $orderTotal += $totalPrice;
    }

    // Convert product IDs array to a comma-separated string
    $productIdsString = implode(',', $productIds);

    // Insert order details into the orders table
    $insertQuery = $conn->prepare("INSERT INTO orders (user_email, product_ids, quantities, total_price, payment_method, 
                                    name, lastname, country, address, phone_number, order_notes,coupon_code,discount,order_status) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?)");
    $insertQuery->bind_param("sssdssssssssss", $user_email, $productIdsString, $quantity, $orderTotal, $paymentMethod, 
                                    $firstName, $lastName, $country, $address, $phone, $orderNotes,$coupon,$discount,$status);
    $insertQuery->execute();
    $insertQuery->close();

    // Clear the user's cart after placing the order
    $clearCartQuery = $conn->prepare("DELETE FROM cart WHERE user_email = ?");
    $clearCartQuery->bind_param("s", $user_email);
    $clearCartQuery->execute();
    $clearCartQuery->close();

    $subject = 'Order Confirmation';
    $message = "
        <html>
        <head>
            <title>Order Confirmation</title>
        </head>
        <body>
            <p>Dear $firstName $lastName,</p>
            <p>Thank you for placing an order with us. Your order details are as follows:</p>
            <table border='1'>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>";
    
    // Loop through cart items and add to the email message
    $result->data_seek(0);
    while ($row = $result->fetch_assoc()) {
        $message .= "<tr>
                        <td>{$row['name']}</td>
                        <td>{$row['quantity']}</td>
                        <td>{$row['t_price']}</td>
                    </tr>";
    }
    
    $message .= "</table>
                <p>Total Order Price: $orderTotal</p>
                <p>Thank you for shopping with us!</p>
                <p>Best Regards,<br>Your Store Team</p>
                </body>
                </html>";

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {


        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username   = 'mohdtaha9901@gmail.com';  
        $mail->Password   = 'bswisjzzmqhpwshl';  
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
    
        $mail->setFrom('mohdtaha9901@gmail.com');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body  = $message;
        $mail->send();
        // Redirect or perform any other actions as needed
        header("Location: checkout.php?confirmation=true");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

$conn->close();
?>
        $mail->Password   = 'bswisjzzmqhpwshl';    // SMTP password
