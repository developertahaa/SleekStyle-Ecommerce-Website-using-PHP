<?php
session_start();
if (!isset($_SESSION['user_email'])) {
    header("location: index.php?alert=true");
    exit; // Make sure to stop the script execution after the redirect
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Male_Fashion Template">
    <meta name="keywords" content="Male_Fashion, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Male-Fashion | Template</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="#">Sign in</a>
                <a href="#">FAQs</a>
            </div>
            <div class="offcanvas__top__hover">
                <span>Usd <i class="arrow_carrot-down"></i></span>
                <ul>
                    <li>USD</li>
                    <li>EUR</li>
                    <li>USD</li>
                </ul>
            </div>
        </div>
        <div class="offcanvas__nav__option">
            <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
            <a href="#"><img src="img/icon/heart.png" alt=""></a>
            <a href="#"><img src="img/icon/cart.png" alt=""> <span>0</span></a>
            <div class="price"><?php echo $total;?></div>
        </div>
        <div id="mobile-menu-wrap"></div>
        <div class="offcanvas__text">
            <p>Free shipping, 30-day return or refund guarantee.</p>
        </div>
    </div>
    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    <header class="header">
        <div class="header__top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-7">
                        <div class="header__top__left">
                            <p>Free shipping, 30-day return or refund guarantee.</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-5">
                        <div class="header__top__right">
                            <div class="header__top__links">
                            <?php
                            if (isset($_SESSION['user_email'])) {
                                echo '<a href="profile.php">Profile</a>';
                            } else {
                                echo '<a href="login.php">Sign in</a>';
                            }
                            ?>
                            <a href="#">FAQs</a>
                            </div>
                            <div class="header__top__hover">
                                <span>Usd <i class="arrow_carrot-down"></i></span>
                                <ul>
                                    <li>USD</li>
                                    <li>EUR</li>
                                    <li>USD</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="header__logo">
                        <h3><b><i>SleekStyle</i></b></h3>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li class="active"><a href="./index.php">Home</a></li>
                            <li><a href="./shop.php">Shop</a></li>
                            <li><a href="#">Categories</a>
                                <ul class="dropdown">
                                <?php
                                    include 'dbcon.php';               
                                    $sql = "SELECT * FROM categories";
                                    $result = $conn->query($sql);

                                    // Check if there are results
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <li><a href="shop.php?category=<?php echo $row['cat_name']; ?>"><?php echo $row['cat_name']; ?></a></li>
                                    <?php }
                                    }
                                    ?>
                                </ul>
                            </li>
                            <li><a href="./contact.php">Contacts</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-3 col-md-3">
                    <div class="header__nav__option">
                        <a href="#" class="search-switch"><img src="img/icon/search.png" alt=""></a>
                        <a href="#"><img src="img/icon/heart.png" alt=""></a>
                        <a href="shopping-cart.php"><img src="img/icon/cart.png" alt=""> <span>0</span></a>
                        <div class="price">$0.00</div>
                    </div>
                </div>
            </div>
            <div class="canvas__open"><i class="fa fa-bars"></i></div>
        </div>
    </header>
    <!-- Header Section End -->

    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="./index.php">Home</a>
                            <a href="./shop.php">Shop</a>
                            <span>Shopping Cart</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="shopping__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Size</th>

                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
include 'dbcon.php';
$user = $_SESSION['user_email'];
$cart_query = "SELECT prod_id, SUM(quantity) as total_quantity, SUM(t_price) as total_price, size FROM cart WHERE user_email = '$user' GROUP BY prod_id, size";
$cart_result = mysqli_query($conn, $cart_query);

// Initialize variables for subtotal and total
$subTotal = 0;

// Check if there are any items in the cart
if (mysqli_num_rows($cart_result) > 0) {
    while ($cart_row = mysqli_fetch_assoc($cart_result)) {
        $prod_id = $cart_row['prod_id'];
        $quantity = $cart_row['total_quantity'];
        $t_price = $cart_row['total_price'];
        $size = $cart_row['size'];

        // Fetch product details from products table based on prod_id
        $product_query = "SELECT * FROM products WHERE id = $prod_id";
        $product_result = mysqli_query($conn, $product_query);

        // Check if the product exists
        if ($product_row = mysqli_fetch_assoc($product_result)) {
            // Calculate the total price for each product

            // Add the total price to the subtotal
            $subTotal += $t_price;
?>
            <tr>
                <td class="product__cart__item">
                    <div class="product__cart__item__pic">
                        <img src="<?php echo $product_row['image']; ?>" style="height:120px !important" alt="">
                    </div>
                    <div class="product__cart__item__text">
                        <h6><?php echo $product_row['name']; ?></h6>
                        <h5>$<?php echo $product_row['price']; ?></h5>
                    </div>
                </td>
                <td class="quantity__item">
                    <div class="quantity">
                        <div class="pro-qty-2">
                            <input type="text" value="<?php echo $quantity; ?>">
                        </div>
                    </div>
                </td>
                <td class="cart__price"><?php echo $size; ?></td>
                <td class="cart__price">$<?php echo $t_price; ?></td>
                <td class="cart__close"><a href="delete_prod.php?id=<?php echo $product_row['id']; ?>"><i class="fa fa-close"></i></a></td>
            </tr>
<?php
        }
    }
} else {
    // Display a message if the cart is empty
    echo "<tr><td colspan='4'>Your cart is empty.</td></tr>";
}
$total = $subTotal;
?>

                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="shop.php">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <input type="text" placeholder="Coupon code" name="coupon">
                            <button type="submit" name="submit">Apply</button>
                        </form>
                    </div>
                    <?php
include 'dbcon.php';

// Initialize $atotal and $discountAmount
$atotal = $total;
$discountAmount = 0;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $couponCode = $_POST['coupon'];

    // Fetch discount details from the coupon table
    $couponQuery = $conn->prepare("SELECT discount FROM coupon WHERE code = ?");
    $couponQuery->bind_param("s", $couponCode);
    $couponQuery->execute();
    $couponQuery->bind_result($discountPercentage);
    $couponQuery->fetch();
    $couponQuery->close();

    if ($discountPercentage) {
        // Valid coupon code, apply discount to $atotal
        $discountAmount = ($discountPercentage / 100) * $total;

        // Calculate the new total after applying the discount
        $atotal = $total - $discountAmount;

        // Store the discount details in session or database as needed
        $_SESSION['coupon_code'] = $couponCode;
        $_SESSION['discount'] = $discountAmount;
    } else {
        // Invalid coupon code, you can handle this case accordingly
        echo "Invalid coupon code. Please try again.";
    }
}

// Close the database connection
$conn->close();
?>

                    <div class="cart__total">
                    <h6>Cart total</h6>
                                        <ul>
                                            <li>Subtotal <span>$<?php echo $total; ?></span></li>
                                            <li>Discount <span>-$<?php echo $discountAmount; ?></span></li>
                                            <li>Total <span>$<?php echo $atotal; ?></span></li>
                                        </ul>

                                        <?php if ($total > 0): ?>
        <a href="checkout.php?sub=<?php echo $total; ?>" class="primary-btn">Proceed to checkout</a>
    <?php else: ?>
        <p>Your cart is empty. Please add items before proceeding to checkout.</p>
        <a href="shop.php" class="primary-btn">Shop Now</a>

    <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->

    <?php
        include 'footer.php';
     ?>
    <!-- Search Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery.nicescroll.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>