<?php
  // 1. Create a database connection
  $dbhost = "localhost";
  $dbuser = "root"; // your username here
  $dbpass = "root"; // your password here
  $dbname = "testDB"; // your db name here
  $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>
<?php
	$request = "";
	
	if(isset($_POST['company_sales'])){
		$request = "company_sales";
		$data1_query = "SELECT SUM((Transaction.product_quantity)*(Transaction.price)) AS 'Total Revenue', (SUM(Transaction.product_quantity*Transaction.price))-(SUM(Transaction.product_quantity*Product.cost)) AS 'Total Profit' 
			FROM Transaction, Product 
			WHERE Transaction.product_id=Product.product_id";
		$data1_result = mysqli_query($connection, $data1_query);
		if (!$data1_result) {
			die("Database query failed."); // bad query syntax
		}
	}
	if(isset($_POST['product_categories'])){
		$request = "product_categories";
		$data2_query = "SELECT Product.product_type AS 'Product Type', SUM((Transaction.product_quantity)*(Transaction.price)) AS Revenue FROM Transaction, Product WHERE Product.product_id=Transaction.product_id GROUP BY Product.product_type ORDER BY Revenue DESC LIMIT 5";
		$data2_result = mysqli_query($connection, $data2_query);
		if (!$data2_result) {
			die("Database query failed."); // bad query syntax
		}
	}
	else if(isset($_POST['region_sales'])){
		$request = "region_sales";
		$data3_query = "SELECT Region.region_name AS Region, SUM((Transaction.product_quantity)*(Transaction.price)) AS Revenue FROM Transaction, Region, Salesperson, Store WHERE Transaction.salesperson_id=Salesperson.salesperson_id AND Salesperson.store_id=Store.store_id AND Store.region_id=Region.region_id GROUP BY Region.region_name";
		$data3_result = mysqli_query($connection, $data3_query);
		if (!$data3_result) {
			die("Database query failed."); // bad query syntax
		}
	}
	else if(isset($_POST['business_products'])){
		$request = "business_products";
		$data4_query = "SELECT temp.customer_id,temp.business_name, sum(temp.product_quantity) as total_amount from 
		(SELECT Customer_Business.customer_id,Customer_Business.business_name, Transaction.product_quantity 
		FROM Customer_Business, Transaction
		WHERE Transaction.customer_ID = Customer_Business.customer_id) AS temp
		GROUP BY temp.customer_id
		Order by total_amount DESC LIMIT 5";
		$data4_result = mysqli_query($connection, $data4_query);
		if (!$data4_result) {
			die("Database query failed."); // bad query syntax
		}
	}
	else if(isset($_POST['best_seller'])){
		$request = "best_seller";
		$data5_query = "SELECT T.product_ID, P.product_name, sum(T.product_quantity) as Amount 
		from Transaction as T, product as P
		WHERE T.product_ID = P.product_id
		Group by T.product_ID
		Order by Amount DESC limit 10";
		$data5_result = mysqli_query($connection, $data5_query);
		if (!$data5_result) {
			die("Database query failed."); // bad query syntax
		}
	}
?>

<!DOCTYPE html>

<html>
	<head>
	<meta charset="UTF-8">
	<title>CosBeauty</title>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<!--[if IE]>
		<link rel="stylesheet" href="css/ie.css" type="text/css" charset="utf-8">
	<![endif]-->
</head>
<body>
	<div id="page">
		<div id="header">
			<div id="logo">
				<a href="index.html"><img src="images/homelogo.png" alt="LOGO"></a>
			</div>
			<div id="navigation">
				<ul>
					<li>
						<a href="index.html">HOME</a>
					</li>
					<li>
						<a href="customers.php">CUSTOMER LOGIN</a>
					</li>
					<li>
						<a href="employees.php">EMPLOYEE LOGIN</a>
					</li>
					<li>
						<a href="data.php">DATA AGGREGATION</a>
					</li>
					<li>
						<a href="contact.html">Contact</a>
					</li>
				</ul>
			</div>
		</div>




	<div id="contents">
			<div id="main">
				<div id="adbox">
					<div class="contentbox details">
						<ul>
								<h2>
								<table>
								<tr>
								<td><b>Business ID</b></td>
								<td><b>Business Name</b></td>
								<td><b>Quantity</b></td>
								</tr>
								
<?php
		while($subject = mysqli_fetch_assoc($data4_result)) {
			$prod4 = $subject['customer_id'];
			$cust4 = $subject['business_name'];
			$stock4 = $subject['total_amount'];
			
			// output data from each row
			echo "<tr>";
			echo "<td>" . $prod4 . "</td>";
			echo "<td>" . $cust4 . "</td>";
			echo "<td>" . $stock4 . "</td>"; 
			echo "</tr>";
		}
?>
</table>
</h2>
</ul>







	<?php
		// 4. Release returned data
		mysqli_free_result($result);
	?>
					</div>
				</div>
			</div>
			<div id="sidebar">
				<h1>
					Cosmetics
				</h1>
								<ul class="menu">
					<li>
						<form action="makeup.php" method="post">
							<input type="submit" name="makeup" value="Makeup" class = "btnCart">
						</form>
					</li>

					<li>
						<form action="skincare.php" method="post">
							<input type="submit" name="skincare" value="Skincare" class = "btnCart">
						</form>
					</li>
					<li>
						<form action="fragrance.php" method="post">
							<input type="submit" name="fragrance" value="Fragrance" class = "btnCart">
						</form>
					</li>
					<li>
						<form action="bath&body.php" method="post">
							<input type="submit" name="bath&body" value="Bath&body" class = "btnCart">
						</form>
					</li>
					<li>
						<form action="Nails.php" method="post">
							<input type="submit" name="nails" value="Nails" class = "btnCart">
						</form>
					</li>
					<li>
						<form action="Brushes.php" method="post">
							<input type="submit" name="Brushes" value="Brushes" class = "btnCart">
						</form>
					</li>
				</ul>
			</div>
		</div>


</body>
</html>

<?php
	// 5. Close database connection
	mysqli_close($connection);
?>