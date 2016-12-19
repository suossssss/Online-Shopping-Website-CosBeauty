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
					<li  class="selected">
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
					<div class="info">
						<h1>Welcome :)</h1>
						<p>Some data aggregations are available for viewing.</p>
						<p> 
							Click the buttons below to view the most recent data.
						</p>
			<form action="data_result1.php" method="post">
				<label for="company_sales">Total Company Sales and Profits</label>
				<input type="submit" name="company_sales" value="Go"/>
			</form>
		<br/>
			<form action="data_result2.php" method="post">
				<label for="product_categories">Top 5 Product Categories by Sales</label>
				<input type="submit" name="product_categories" value="Go"/>
			</form>
		<br/>
			<form action="data_result3.php" method="post">
				<label for="region_sales">Sales by Region</label>
				<input type="submit" name="region_sales" value="Go"/>
			</form>
		<br/>
			<form action="data_result4.php" method="post">
				<label for="business_products">Most Purchased Product by Each Business</label>
				<input type="submit" name="business_products" value="Go"/>
			</form>
		<br/>
			<form action="data_result5.php" method="post">
				<label for="best_seller">Top 10 Best Seller</label>
				<input type="submit" name="best_seller" value="Go"/>
			</form>
							<br/>

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