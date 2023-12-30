<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include 'dbcon.php';

// Fetch user information and order/cart details
$userEmail = $_SESSION['user_email'];

// Fetch total number of orders
$orderQuery = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_email = ?");
$orderQuery->bind_param("s", $userEmail);
$orderQuery->execute();
$orderQuery->bind_result($totalOrders);
$orderQuery->fetch();
$orderQuery->close();


$orderStatus = 'Delivered';
$orderQue = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_email = ? AND order_status = ?");
$orderQue->bind_param("ss", $userEmail, $orderStatus);
$orderQue->execute();
$orderQue->bind_result($deliveredOrders);
$orderQue->fetch();
$orderQue->close();


// Fetch total money spent
$spentQuery = $conn->prepare("SELECT SUM(total_price) FROM orders WHERE user_email = ?");
$spentQuery->bind_param("s", $userEmail);
$spentQuery->execute();
$spentQuery->bind_result($totalMoneySpent);
$spentQuery->fetch();
$spentQuery->close();

// Fetch the number of items in the cart
$cartQuery = $conn->prepare("SELECT COUNT(*) FROM cart WHERE user_email = ?");
$cartQuery->bind_param("s", $userEmail);
$cartQuery->execute();
$cartQuery->bind_result($itemsInCart);
$cartQuery->fetch();
$cartQuery->close();

// Fetch ordered items
$orderedItemsQuery = $conn->prepare("SELECT product_ids, quantities, total_price,order_status FROM orders WHERE user_email = ?");
$orderedItemsQuery->bind_param("s", $userEmail);
$orderedItemsQuery->execute();
$orderedItems = $orderedItemsQuery->get_result()->fetch_all(MYSQLI_ASSOC);
$orderedItemsQuery->close();

// Fetch items in the cart
$cartItemsQuery = $conn->prepare("SELECT prod_id, quantity, t_price FROM cart WHERE user_email = ?");
$cartItemsQuery->bind_param("s", $userEmail);
$cartItemsQuery->execute();
$cartItems = $cartItemsQuery->get_result()->fetch_all(MYSQLI_ASSOC);
$cartItemsQuery->close();

// Fetch all product names
$productNamesQuery = $conn->query("SELECT id, name FROM products");
$productNames = [];
while ($row = $productNamesQuery->fetch_assoc()) {
    $productNames[$row['id']] = $row['name'];
}
$productNamesQuery->close();

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<link rel="stylesheet" href="admin/style.css">

	<title>SleekStyle</title>
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">SleekStyle</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
		
			
		</ul>
		<ul class="side-menu">
			<li>
				<a href="profile.php">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				
			</div>

			<ul class="box-info">
    <li>
        <i class='bx bxs-calendar-check' ></i>
        <span class="text">
            <h3> <?php echo $totalOrders; ?></h3>
            <p>Total Orders</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-group' ></i>
        <span class="text">
            <h3> <?php echo $deliveredOrders; ?></h3>
            <p>Delivered</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-dollar-circle' ></i>
        <span class="text">
            <h3>$<?php echo $totalMoneySpent; ?></h3>
            <p>Total Spend</p>
        </span>
    </li>
</ul>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>Product </th>
								<th>Price </th>
								<th>Status</th>
								<th>Cancel</th>

							</tr>
						</thead>
						<tbody>
						<?php foreach ($orderedItems as $item): ?>
                                <?php
                                $productIds = explode(',', $item['product_ids']);
                                foreach ($productIds as $productId) {
                                    $productName = isset($productNames[$productId]) ? $productNames[$productId] : "Unknown Product";
								?>
								<tr>
									<td>    
										<img src="img/people.png">
										<p><?php echo $productName; ?></p>
									</td>
									<td>
										<p>            <?php echo $item['total_price']; ?></p>
									</td>
									<td>
										<p>            <?php echo $item['order_status']; ?></p>
									</td>
									<td> <button type="submit" name="delete" class="btn btn-danger">Cancel Order</button></td>

							
								</tr>

                            <?php } endforeach; ?>
</tbody>
					</table>
				</div>

			</div>
		</main>
		<!-- MAIN -->
								</section>


								<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script src="admin/script.js"></script>

	
</body>
</html>