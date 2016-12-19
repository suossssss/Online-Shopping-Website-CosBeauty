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
	if(isset($_POST['search'])){
		$id = $_POST['product_id'];
		$product_query = "SELECT * FROM Product WHERE product_id = $id";
		
		$product_result = mysqli_query($connection, $product_query);
		if (!$product_result) {
			die("Database query failed."); // bad query syntax error
		}
		 else if (mysqli_num_rows($product_result) != 1) {
		  die("You enter wrong product ID ,please try again."); 
	  }
		
		$product_row = mysqli_fetch_assoc($product_result);
		$id = $product_row['product_id'];
		$name = $product_row['product_name'];
		$quant = $product_row['quantity'];
		$price = $product_row['price'];
		$cost = $product_row['cost'];
		$type = $product_row['product_type'];
	}
?>
<?php
	if(isset($_POST['submit'])) {
		$id2 = $_POST['product_id'];
		$name2 = $_POST['product_name'];
		$quant2 = $_POST['quantity'];
		$price2 = $_POST['price'];
		$cost2 = $_POST['cost'];
		$type2 = $_POST['product_type'];
		
		$update_query = "UPDATE Product SET product_name = '$name2', quantity = '$quant2', price = '$price2', cost = '$cost2', product_type = '$type2' WHERE product_id = '$id2'";
		
		$update_result = mysqli_query($connection, $update_query);
		
		#echo "Debugging: ";
		#print_r($_POST);
		
		if ($update_result) {
			echo "Success!";
		} else {
			print_r($_POST);
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
					<li>
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
	<h2>Edit Inventory</h2>
	<form action="editInv.php" method="post">
		<div>
			<label for="product_id">Product ID: </label><br/>
			<input type="text" name="product_id" value="<?php echo $id;?>" /> <br/>
		</div>
		<div>
			<label for="product_name">Name: </label><br/>
			<input type="text" name="product_name" value="<?php echo $name;?>" /><br/>
		</div>
		<div>
			<label for="quantity">Quantity: </label><br/>
			<input type="text" name="quantity" value="<?php echo $quant;?>" /><br/>
		</div>
		<div>
			<label for="price">Price: </label><br/>
			<input type="text" name="price" value="<?php echo $price;?>" /><br/>
		</div>
		<div>
			<label for="cost">Unit Cost: </label><br/>
			<input type="text" name="cost" value="<?php echo $cost;?>" /><br/>
		</div>
		<div>
			<label for="product_type">Type: </label><br/>
			<select name="product_type">
				<option value="MakeUp"<?php echo ($type == 'makeup') ? 'selected="selected"': '';?>>Makeup</option>
				<option value="Fragrance"<?php echo ($type == 'Fragrance') ? 'selected="selected"': '';?>>Fragrance</option>
				<option value="SkinCare"<?php echo ($type == 'skincare') ? 'selected="selected"': '';?>>SkinCare</option>
				<option value="Bath&Body"<?php echo ($type == 'Bath&Body') ? 'selected="selected"': '';?>>Bath&Body</option>
				<option value="Nails"<?php echo ($type == 'Nails') ? 'selected="selected"': '';?>>Nails</option>
				<option value="Hair"<?php echo ($type == 'Hair') ? 'selected="selected"': '';?>>Hair</option>
				<option value="Brushes"<?php echo ($type == 'Brushes') ? 'selected="selected"': '';?>>Brushes</option>
				
			</select>
		</div>
		<div><input type="submit" name="submit" value="Submit"><br/></div>
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
