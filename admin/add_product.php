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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>SleekStyle</title>
    <style>
        .danger{
            background-color: crimson !important;
        }
    </style>
</head>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">SleekStyle</span>
		</a>
		<ul class="side-menu top">
			<li >
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
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
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="display:none;">
    <strong>Success</strong> Product Added SuccesFully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
if (isset($_GET['confirmation']) == true) {
?>
    <script>
        document.querySelector('.alert').style.display = 'block';
    </script>
<?php }
?>
        <div class="alert alert-success alert-dismissible fade show delete" role="alert" style="display:none;">
    <strong>Success</strong> Product Deleted SuccesFully.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
if (isset($_GET['deletion']) == true) {
?>
    <script>
        document.querySelector('.delete').style.display = 'block';
    </script>
<?php }
?>
            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Products</h3>
						<i class='bx bx-search' ></i>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Add More Products</button>
					</div>
                    <?php
$sqlRecentOrders = "SELECT * FROM products"; // Assuming you want to display the latest 5 orders
$resultRecentOrders = $conn->query($sqlRecentOrders);
?>
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Category</th>
                                <th>Price(Rs.)</th>
                                <th>Rating /5</th>
                                <th>EDIT</th>
                                <th>DELETE</th>
							</tr>
						</thead>
                        <tbody>
                            <?php while ($row = $resultRecentOrders->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <p><?php echo $row['name']; ?></p>
                                    </td>
                                    <td><?php echo $row['category']; ?></td>
                                    <td><?php echo $row['price']; ?></td>
                                    <td><?php echo $row['rating']; ?></td>
                                    <form action="add.php" method="post">
                                    <td> <button type="submit" name="edit" class="btn btn-success">EDIT</button></td>
                                    <input type="text" name = "id" value="<?php echo $row['id'];?>" hidden>
                                    <td> <button type="submit" name="delete" class="btn btn-danger">DELETE</button></td>
                                    </form>
                                </tr> 
                            <?php endwhile; ?>
                        </tbody>
					</table>

				</div>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

   <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="add.php" method="post">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Name</label>
            <input type="text" class="form-control" name="name" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Category</label>
            <input type="text" class="form-control" name="category" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Price</label>
            <input type="number" class="form-control" name="price" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Rating</label>
            <input type="number" class="form-control" name="rating" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Label</label>
            <input type="text" class="form-control" name="label" id="recipient-name">
          </div>
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Product Description</label>
            <input type="text" class="form-control" name="desc" id="recipient-name">
          </div>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" name="submit" class="btn btn-primary">ADD</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>