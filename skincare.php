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
	if(isset($_POST['skincare'])){
		#$sid = $_POST['product_id'];
		#$sname = $_POST['product_name'];
		#$sprice = $_POST['price'];
		#$stype = $_POST['product_type'];
		
		$select_any = "SELECT * FROM Product WHERE product_type='skincare'";
		$select_any_result = mysqli_query($connection, $select_any);
		if (!$select_any_result) {
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
			<td><b>Product ID</b></td>
			<td><b>Product Name</b></td>
			<td><b>In Stock</b></td>
			<td><b>Price</b></td>
			<td><b>Product Type</b></td>
		</tr>
		<?php
	while($subject = mysqli_fetch_assoc($select_any_result)) 
	{
			$id = $subject['product_id'];
			$name = $subject['product_name'];
			$stock = $subject['quantity'];
			$price = $subject['price'];
			$type = $subject['product_type'];
			
			// output data from each row
			echo "<tr>";
			echo "<td>" . $id . "</td>";
			echo "<td>" . $name . "</td>";
			echo "<td>" . $stock . "</td>"; 
			echo "<td>" . $price . "</td>";
			echo "<td>" . $type . "</td>";
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