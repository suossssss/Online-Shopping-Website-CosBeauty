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
  	  $login_id = $_POST['customer_id'];
	  $login_query = "SELECT customer_id FROM Customer WHERE customer_id = '$login_id'";
	  $login_result = mysqli_query($connection, $login_query);
	  if (!$login_result) {
		  die("Database query failed."); // bad query syntax

	  } 
	   else if (mysqli_num_rows($login_result) != 1) {
		  header("Location: bad_login.php");
	  }
  }
?>
<?php
	// Get next index
	$max_query = "SELECT MAX(order_id) FROM Transaction";
	
	$max_result = mysqli_query($connection, $max_query);
	if (!$max_result) {
		die("Database query failed."); // bad query syntax error
	}
	
	$max_row = mysqli_fetch_assoc($max_result);
	$max = $max_row["MAX(order_id)"];
	$new_id = $max + 1;
?>
<?php
	if(isset($_POST['submit'])){
		$order = $_POST['order_id'];
		$date = $_POST['order_date'];
		$sales = $_POST['salesperson_id'];
		$cust = $_POST['customer_id'];
		$prod = $_POST['product_id'];
		$quant = $_POST['product_quantity'];
		
		// check customer and product ids
		$check_cust = "SELECT * FROM Customer WHERE customer_id = $cust";
		$check_prod = "SELECT * FROM Product WHERE product_id = $prod";
		
		$check_cust_result = mysqli_query($connection, $check_cust);
		if (!$check_cust_result) {
			die("Database query failed."); // bad query syntax error
		} else if (mysqli_num_rows($check_cust_result) < 1) {
			die("Customer does not exist. Please create customer first.");
		}
		
		$check_prod_result = mysqli_query($connection, $check_prod);
		if (!$check_prod_result) {
			die("Database query failed."); // bad query syntax error
		} else if (mysqli_num_rows($check_prod_result) < 1) {
			die("Product does not exist. Please create product first.");
		}
		
		// get price and inventory
		$price_query = "SELECT * FROM Product WHERE product_id = $prod";
		$price_result = mysqli_query($connection, $price_query);
		if (!$price_result) {
			die("Database query failed."); // bad query syntax error
		}
		
		$price_row = mysqli_fetch_assoc($price_result);
		$inventory = $price_row['quantity'];
		$price = $price_row['price'];
		$total = $price * $quant;
		
		if ($quant > $inventory) {
			die("Sorry, we don't have enough of the product you're looking for.");
		}

        // get and update account
		$get_account = "SELECT * FROM Accounts WHERE customer_id = '$cust'";
		$get_account_result = mysqli_query($connection, $get_account);
		if (!$get_account_result) {
			die("Database query failed."); // bad query syntax error
		}
		
		$account_row = mysqli_fetch_assoc($get_account_result);
		$balance = $account_row['balance'];
		
		if ($balance < $total) {
			die("Sorry, your current balance cannot afford the payment! ");
		}
				
		// add transaction
		$add_trans = "INSERT INTO Transaction VALUES ('$order', '$date', '$sales', '$prod', '$cust', '$quant', '$total')";
		$add_result = mysqli_query($connection, $add_trans);
		if ($add_result) {
			echo "Successfully added transaction #" . $order . "; Total = $" . $total . "<br/>";
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		
		
		//update balance
		$balance = $balance - $total;
		$update_account = "UPDATE Accounts SET balance = '$balance' WHERE customer_id = '$cust'";
		$update_account_result = mysqli_query($connection, $update_account);
		if ($update_account_result) {
			echo "Updated Balance: $" . $balance . "<br/>";
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		// update inventory
		$inventory2 = $inventory - $quant;
		$update_inventory = "UPDATE Product SET quantity = '$inventory2' WHERE product_id = '$prod'";
		$update_inventory_result = mysqli_query($connection, $update_inventory);
		if ($update_inventory_result) {
			echo "Updated Inventory: " . $inventory2 . " remaining";
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
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
					<li class="selected">
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
					<div class="info">
	<h2>Add Orders</h2>
	<form action="addTrans.php" method="post">
		<div>
			<label for="order_id">Order #: </label>
			<input type="text" name="order_id" value="<?php echo $new_id; ?>"/>
		</div>
		<br/>
		<div>
			<label for="order_date">Date: </label>
			<input type="text" name="order_date" />
		</div>
		<div>
			<label for="salesperson_id">Salesperson: </label>
			<input type="text" name="salesperson_id" />
		</div>
		<div>
			<label for="customer_id">Customer ID: </label>
			<input type="text" name="customer_id" />
		</div>
		<br/>
		<div>
			<label for="product_id">Item ID: </label>
			<input type="text" name="product_id" />
		</div>
		<div>
			<label for="product_quantity">Quantity: </label>
			<input type="text" name="product_quantity" />
		</div>
		<br/> 
		<input type="submit" name="submit" value="Submit" />
		


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