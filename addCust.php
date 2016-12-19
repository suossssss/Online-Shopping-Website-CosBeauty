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
	// Get next index
	$max_query = "SELECT MAX(customer_id) FROM Customer";
	
	$max_result = mysqli_query($connection, $max_query);
	if (!$max_result) {
		die("Database query failed."); // bad query syntax error
	}
	
	$max_row = mysqli_fetch_assoc($max_result);
	$max = $max_row["MAX(customer_id)"];
	$new_id = $max + 1;
?>
<?php
	// On submit - create customer, account, home/business 
	if(isset($_POST['submit'])){
		$id = $_POST['customer_id'];
		$name = $_POST['customer_name'];
		$street = $_POST['customer_address_street'];
		$city = $_POST['customer_address_city'];
		$state = $_POST['customer_address_state'];
		$zip = $_POST['customer_address_zip'];
		$type = $_POST['customer_type'];
		$gender = $_POST['gender'];
		$age = $_POST['age'];
		$home_income = $_POST['home_income'];
		$marriage = $_POST['marriage_status'];
		$category = $_POST['business_category'];
		$business_income = $_POST['business_income'];
		
		
        if($age<0){
        	die("You enter wrong information,please try again. " . mysqli_error($connection));
        }

		// Create customer
		$add_cust = "INSERT INTO Customer VALUES ('$id', '$name', '$street', '$city', '$state', '$zip', '$type')";
		
		$add_result = mysqli_query($connection, $add_cust);
		if ($add_result) {
			echo "Successfully added customer " . $id. "; "; 
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		
		// Create account
		$add_account = "INSERT INTO Accounts VALUES ('$id', 0)";
		$account_result = mysqli_query($connection, $add_account);
		if ($account_result) {
			echo "Successfully created account #" . $id . "; ";
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		
		// Decide if home or business, and create appropriately
		if ($type == 'home') {
			$add_home = "INSERT INTO Customer_Home VALUES ('$id', '$marriage', '$gender', '$age', '$home_income')";
			$home_result = mysqli_query($connection, $add_home);
			if ($home_result) {
				echo "Successfully created home customer.";
			} else {
				die("Database query failed. " . mysqli_error($connection));
			}
		} else {
			$add_business = "INSERT INTO Customer_Business VALUES ('$id', '$category', '$business_income')";
			$business_result = mysqli_query($connection, $add_business);
			if ($business_result) {
				echo "Successfully created business customer.";
			} else {
				die("Database query failed. " . mysqli_error($connection));
			}
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
					<li class="selected">
						<a href="customers.php">CUSTOMER LOGIN</a>
					</li>
					<li >
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
	<h2>Add Customer</h2>
	<form id="addCust" action="addCust.php" method="post">
		<div>
			<label for="customer_id">Customer ID: </label><br/>
			<input type="text" name="customer_id" value="<?php echo $new_id; ?>" readonly /><br/>
		</div>
		<div>
			<label for="customer_name">Name: </label><br/>
			<input type="text" name="customer_name" /><br/>
		</div>
		<div>
			<label for="customer_address_street">Street: </label><br/>
			<input type="text" name="customer_address_street" /><br/>
			<label for="customer_address_city">City: </label><br/>
			<input type="text" name="customer_address_city" /><br/>
			<label for="customer_address_state">State: </label><br/>
			<input type="text" name="customer_address_state" /><br/>
			<label for="customer_address_zip">Zip: </label><br/>
			<input type="text" name="customer_address_zip" /><br/>
		</div>
		<div>
			<label for="customer_type">Type: </label><br/>
			<select name="customer_type" id="customer_type"><br/>
				<option value="home">Home</option>
				<option value="business">Business</option>
			</select>
		</div>
		<div id="home">
			<label for="gender">Gender (Home): </label><br/>
			<input type="text" name="gender" /><br/>
			<label for="age">Age (Home): </label><br/>
			<input type="text" name="age" /><br/>
			<label for="home_income">Yearly Income (Home): </label><br/>
			<input type="text" name="home_income" /><br/>
			<label for="marriage_status">Marital Status (Home): </label><br/>
			<input type="text" name="marriage_status" /><br/>
		</div>
		<div id="business">
			<label for="business_category">Type of Business (Business): </label><br/>
			<input type="text" name="business_category" /><br/>
			<label for="business_income">Yearly Income ß(Business): </label><br/>
			<input type="text" name="business_income" /><br/>
		</div>
		<div><input type="submit" name="submit" value="Submit" /></div>
	</form>
	<h2>
		To edit a customer profile, enter the customer 
		ID below and click "Search"
	</h2>
	<form action="editCust.php" method="post">
		<label for="customer_id">Customer ID: </label><br/>
		<input type="text" name="customer_id" /><br/>
		<input type="submit" name="search" value="Search">
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

