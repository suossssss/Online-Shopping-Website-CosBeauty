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
  if(isset($_POST['login'])){
  	  $login_id = $_POST['emp_id'];
	  $login_query = "SELECT emp_id FROM Employees WHERE emp_id = '$login_id'";
	  $login_result = mysqli_query($connection, $login_query);
	  if (!$login_result) {
		  die("Database query failed."); // bad query syntax
	  } else if (mysqli_num_rows($login_result) != 1) {
		  header("Location: bad_login.php");
	  }
  }
?>
<?php
	$max_query = "SELECT MAX(product_id) FROM Product";
	
	$max_result = mysqli_query($connection, $max_query);
	if (!$max_result) {
		die("Database query failed."); // bad query syntax error
	}
	
	$max_row = mysqli_fetch_assoc($max_result);
	$max = $max_row["MAX(product_id)"];
	$new_id = $max + 1;
?>
<?php
	if(isset($_POST['submit'])){
		$id = $_POST['product_id'];
		$name = $_POST['product_name'];
		$quant = $_POST['quantity'];
		$price = $_POST['price'];
		$cost = $_POST['unit_cost'];
		$type = $_POST['product_type'];
		
		$add_cust = "INSERT INTO Product VALUES ('$id', '$name', '$quant', '$price', '$cost', '$type')";
		
		$add_result = mysqli_query($connection, $add_cust);
		if ($add_result) {
			echo "Successfully added product " . $id; 
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>CustomerLogin</title>
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
					<li >
						<a href="customers.php">CUSTOMER LOGIN</a>
					</li>
					<li class="selected">
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
					<div class="box">
	<h2>Add Inventory</h2>
	<form action="addInv.php" method="post">
		<div>
			<label for="product_id">Product ID: </label><br/>
			<input type="text" name="product_id" value="<?php echo $new_id; ?>"/> <br/>
		</div>
		<div>
			<label for="product_name">Name: </label><br/>
			<input type="text" name="product_name" /><br/>
		</div>
		<div>
			<label for="quantity">Quantity: </label><br/>
			<input type="text" name="quantity" /><br/>
		</div>
		<div>
			<label for="price">Price: </label><br/>
			<input type="text" name="price" /><br/>
		</div>
		<div>
			<label for="unit_cost">Unit Cost: </label><br/>
			<input type="text" name="unit_cost" /><br/>
		</div>
		<div>
			<label for="product_type">Type: </label><br/>
			<select name="product_type">
				<option value="MakeUp">MakeUp</option>
				<option value="Fragrance">Fragrance</option>
				<option value="SkinCare">SkinCare</option>
				<option value="Bath&Body">Bath&Body</option>
				<option value="Nails">Nails</option>
				<option value="Hair">Hair</option>
				<option value="Brushes">Brushes</option>
			</select>
		</div>
		<div><input type="submit" name="submit" value="Submit" /><br/></div>
	</form>
	<h2>
		To edit inventory, enter the product ID 
		below and click "Search"
	</h2>
	<form action="editInv.php" method="post">
		<label for="product_id">Product ID: </label><br/>
		<input type="text" name="product_id" /><br/>
		<input type="submit" name="search" value="Search" /><br/>
	</form>
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
