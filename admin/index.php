<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("location: ../index.php?alert=true");
    exit; // Make sure to stop the script execution after the redirect
}
include '../dbcon.php';
// Total Orders
$sqlTotalOrders = "SELECT COUNT(*) as totalOrders FROM orders";
$resultTotalOrders = $conn->query($sqlTotalOrders);
$rowTotalOrders = $resultTotalOrders->fetch_assoc();
$totalOrders = $rowTotalOrders['totalOrders'];

// Number of Registered Users
$sqlRegisteredUsers = "SELECT COUNT(*) as totalUsers FROM users";
$resultRegisteredUsers = $conn->query($sqlRegisteredUsers);
$rowRegisteredUsers = $resultRegisteredUsers->fetch_assoc();
$totalUsers = $rowRegisteredUsers['totalUsers'];

// Total Sales
$sqlTotalSales = "SELECT SUM(total_price) as totalSales FROM orders";
$resultTotalSales = $conn->query($sqlTotalSales);
$rowTotalSales = $resultTotalSales->fetch_assoc();
$totalSales = $rowTotalSales['totalSales'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

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
			<li>
				<a href="add_product.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">My Store</span>
				</a>
			</li>
			<li>
				<a href="feedback.php">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Message</span>
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
				<a href="../logout.php" class="logout">
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
            <h3><?php echo $totalOrders; ?></h3>
            <p>New Order</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-group' ></i>
        <span class="text">
            <h3><?php echo $totalUsers; ?></h3>
            <p>Visitors</p>
        </span>
    </li>
    <li>
        <i class='bx bxs-dollar-circle' ></i>
        <span class="text">
            <h3>$<?php echo $totalSales; ?></h3>
            <p>Total Sales</p>
        </span>
    </li>
</ul>

<?php
$sqlRecentOrders = "SELECT * FROM orders ORDER BY order_date DESC LIMIT 5"; // Assuming you want to display the latest 5 orders
$resultRecentOrders = $conn->query($sqlRecentOrders);
?>



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
								<th>User</th>
								<th>Date Order</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
    <?php while ($row = $resultRecentOrders->fetch_assoc()): ?>
        <tr>
            <td>
                <img src="img/people.png">
                <p><?php echo $row['name']; ?></p>
            </td>
            <td><?php echo $row['order_date']; ?></td>
        </tr>
    <?php endwhile; ?>
</tbody>
					</table>
				</div>
				<?php
// Fetch products and their total sales
$sqlProductsTotalSales = "SELECT product_ids, SUM(total_price) AS totalSales FROM orders GROUP BY product_ids";
$resultProductsTotalSales = $conn->query($sqlProductsTotalSales);

// Create an associative array to store product IDs and their total sales
$productTotalSales = [];
while ($row = $resultProductsTotalSales->fetch_assoc()) {
    $productTotalSales[$row['product_ids']] = $row['totalSales'];
}

// Fetch product names using product IDs
$productNames = [];
$productIds = implode(',', array_keys($productTotalSales));

if (!empty($productIds)) {
    $sqlProductNames = "SELECT id, name FROM products WHERE id IN ($productIds)";
    $resultProductNames = $conn->query($sqlProductNames);

    while ($row = $resultProductNames->fetch_assoc()) {
        $productNames[$row['id']] = $row['name'];
    }
}
?>

<!-- Insert this where you want to display products with total sales -->
<div class="todo">
    <div class="head">
        <h3>Most Selling Products</h3>
        <i class='bx bx-plus'></i>
		<i id="filter-icon" class='bx bx-filter'></i>
    </div>
    <ul class="todo-list">
	<?php
        // Initialize an array to store accumulated total sales for each product ID
        $accumulatedTotalSales = [];

        // Loop through the products and accumulate total sales for each unique product ID
        foreach ($productTotalSales as $productId => $totalSales) {
            $productIds = explode(',', $productId);

            foreach ($productIds as $individualProductId) {
                if (!isset($accumulatedTotalSales[$individualProductId])) {
                    $accumulatedTotalSales[$individualProductId] = $totalSales / count($productIds);
                } else {
                    $accumulatedTotalSales[$individualProductId] += $totalSales / count($productIds);
                }
            }
        }

        // Display the accumulated total sales for each product
        foreach ($accumulatedTotalSales as $productId => $accumulatedTotalSale) {
            echo '<li class="completed">';
            echo '<p>' . $productNames[$productId] . ' <br> Total Sales: $' . number_format($accumulatedTotalSale, 2) . '</p>';
            echo '<i class="bx bx-dots-vertical-rounded"></i>';
            echo '</li>';
        }
        ?>
    </ul>
</div>


			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	<script>
document.addEventListener('DOMContentLoaded', function () {
    var productData = <?php echo json_encode($accumulatedTotalSales); ?>;
    var productNames = <?php echo json_encode($productNames); ?>;

    function renderProductList(products) {
        var productList = document.querySelector('.todo-list');
        productList.innerHTML = '';

        // Convert the accumulatedTotalSales object to an array of objects for sorting
        var productArray = Object.keys(products).map(function (productId) {
            return { id: productId, totalSales: products[productId] };
        });

        // Sort the product data based on totalSales
        productArray.sort(function (a, b) {
            return isDescending ? b.totalSales - a.totalSales : a.totalSales - b.totalSales;
        });

        // Render the sorted product list
        productArray.forEach(function (product) {
            var productName = productNames[product.id]; // Use product ID to fetch the correct name
            var accumulatedTotalSale = product.totalSales.toFixed(2);

            var listItem = document.createElement('li');
            listItem.className = 'completed';
            listItem.innerHTML = '<p>' + productName + '<br> Total Sales: $' + accumulatedTotalSale + '</p>' +
                '<i class="bx bx-dots-vertical-rounded"></i>';
            productList.appendChild(listItem);
        });
    }

    var isDescending = false;

    document.getElementById('filter-icon').addEventListener('click', function () {
        isDescending = !isDescending;
        renderProductList(productData);
    });

    // Initial render of the product list
    renderProductList(productData);
});
</script>


	<script src="script.js"></script>

	
</body>
</html>