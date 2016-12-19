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
		$id = $_POST['customer_id'];
		
		// Get customer data from Customer table
		$customer_query = "SELECT * FROM Customer WHERE customer_id = $id";
		$customer_result = mysqli_query($connection, $customer_query);
		if (!$customer_result) {
			die("Database query failed."); // bad query syntax error
		}
		 else if (mysqli_num_rows($customer_result) != 1) {
		  header("Location: bad_login.php");
	  }

		
		$customer_row = mysqli_fetch_assoc($customer_result);
		$id = $customer_row['customer_id'];
		$name = $customer_row['customer_name'];
		$street = $customer_row['customer_address_street'];
		$city = $customer_row['customer_address_city'];
		$state = $customer_row['customer_address_state'];
		$zip = $customer_row['customer_address_zip'];
		$type = $customer_row['customer_type'];
		
		// Prep variables for home/business
		$marriage = "";
		$gender = "";
		$age = "";
		$home_income = "";
		$category = "";
		$business_income = "";
		
		// Get customer data from Home or Business table
		if ($type == 'home') {
			// Home table
			$home_query = "SELECT * FROM Customer_Home WHERE customer_id = $id";
			$home_result = mysqli_query($connection, $home_query);
			if (!$home_result) {
				die("Database query failed."); // bad query syntax error
			}
			
			$home_row = mysqli_fetch_assoc($home_result);
			$marriage = $home_row['marriage_status'];
			$gender = $home_row['gender'];
			$age = $home_row['age'];
			$home_income = $home_row['home_income'];
		} else {
			// Business table
			$business_query = "SELECT * FROM Customer_Business WHERE customer_id = $id";
			$business_result = mysqli_query($connection, $business_query);
			if (!$business_result) {
				die("Database query failed."); // bad query syntax error
			}
			
			$business_row = mysqli_fetch_assoc($business_result);
			$category = $business_row['business_category'];
			$business_income = $business_row['business_income'];
		}
		
		// Get customer data from Accounts table
		$account_query = "SELECT * FROM Accounts WHERE customer_id = $id";
		$account_result = mysqli_query($connection, $account_query);
		if (!$account_result) {
			die("Database query failed."); // bad query syntax error
		}
		
		$account_row = mysqli_fetch_assoc($account_result);
		$balance = $account_row['balance'];
	}
?>
<?php
	if(isset($_POST['submit'])) {
		$id2 = $_POST['customer_id'];
		$name2 = $_POST['customer_name'];
		$street2 = $_POST['customer_address_street'];
		$city2 = $_POST['customer_address_city'];
		$state2 = $_POST['customer_address_state'];
		$zip2 = $_POST['customer_address_zip'];
		$type2 = $_POST['customer_type'];
		$gender2 = $_POST['gender'];
		$age2 = $_POST['age'];
		$home_income2 = $_POST['home_income'];
		$marriage2 = $_POST['marriage_status'];
		$category2 = $_POST['business_category'];
		$business_income2 = $_POST['business_income'];
		$balance2 = $_POST['balance'];
		
		// Update Customer Table
		$update_customer_query = "UPDATE Customer SET customer_name = '$name2', customer_address_street = '$street2', customer_address_city = '$city2', customer_address_state = '$state2', customer_address_zip = '$zip2', customer_type = '$type2' WHERE customer_id = '$id2'";
		
		$update_customer_result = mysqli_query($connection, $update_customer_query);
		
		if ($update_customer_result) {
			echo "Successfully updated customer " . $id2 . "; ";
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		
		// Update Home/Business Table
		if ($type2 == 'home') {
			$update_home_query = "UPDATE Customer_Home SET marriage_status = '$marriage2', gender = '$gender2', age = '$age2', home_income = '$home_income2' WHERE customer_id = '$id2'";
			$update_home_result = mysqli_query($connection, $update_home_query);
			if ($update_home_result) {
				echo "Successfully updated home customer " . $id2 . "; ";
			} else {
				die("Database query failed. " . mysqli_error($connection));
			}
		} else {
			$update_business_query = "UPDATE Customer_Business SET business_category = '$category2', business_income = '$business_income2' WHERE customer_id = '$id2'";
			$update_business_result = mysqli_query($connection, $update_business_query);
			if ($update_business_result) {
				echo "Successfully updated business customer " . $id2 . "; ";
			} else {
				die("Database query failed. " . mysqli_error($connection));
			}
		}
		
		// Update Account
		$update_account_query = "UPDATE Accounts SET balance = '$balance2' WHERE customer_id = '$id2'";
		$update_account_result = mysqli_query($connection, $update_account_query);
		if ($update_account_result) {
			echo "Successfully updated account #" . $id2;
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
					<div class="box">
	<h2>Edit Customer</h2>
	<form action="editCust.php" method="post">
		<div>
			<label for="customer_id">Customer ID: </label><br/>
			<input type="text" name="customer_id" value="<?php echo $id; ?>" /><br/>
		</div>
		<div>
			<label for="customer_name">Name: </label><br/>
			<input type="text" name="customer_name" value="<?php echo $name; ?>" /><br/>
		</div>
		<div>
			<label for="customer_address_street">Street: </label><br/>
			<input type="text" name="customer_address_street" value="<?php echo $street; ?>" /><br/>
			<label for="customer_address_city">City: </label><br/>
			<input type="text" name="customer_address_city" value="<?php echo $city; ?>" /><br/>
			<label for="customer_address_state">State Abbr.: </label><br/>
			<input type="text" name="customer_address_state" value="<?php echo $state; ?>" /><br/>
			<label for="customer_address_zip">Zip: </label><br/>
			<input type="text" name="customer_address_zip" value="<?php echo $zip; ?>" /><br/>
		</div>
		<div>
			<label for="customer_type">Type: </label><br/>
			<select name="customer_type"><br/>
				<option value="home"<?php echo ($type == 'home') ? 'selected="selected"': '';?>>Home</option>
				<option value="business"<?php echo ($type == 'business') ? 'selected="selected"': '';?>>Business</option>
			</select>
		</div>
		<div id="home"<?php if ($type == 'business') {echo ' style="display:none"';}?>>
			<label for="gender">Gender: </label><br/>
			<input type="text" name="gender" value="<?php echo $gender;?>" /><br/>
			<label for="age">Age: </label><br/>
			<input type="text" name="age" value="<?php echo $age;?>" /><br/>
			<label for="home_income">Yearly Income: </label><br/>
			<input type="text" name="home_income" value="<?php echo $home_income;?>" /><br/>
			<label for="marriage_status">Marital Status: </label><br/>
			<input type="text" name="marriage_status" value="<?php echo $marriage;?>" /><br/>
		</div>
		<div id="business"<?php if ($type == 'home') {echo ' style="display:none"';}?>><br/>
			<label for="business_category">Type of Business: </label><br/>
			<input type="text" name="business_category" value="<?php echo $category;?>" /><br/>
			<label for="business_income">Yearly Income: </label><br/>
			<input type="text" name="business_income" value="<?php echo $business_income;?>" /><br/>
		</div>
		<p>Account Information:</p>
		<div>
			<label for="balance">Balance: </label><br/>
			<input type="text" name="balance" value="<?php echo $balance;?>"><br/>
		</div>
		<br/>
		<div><input type="submit" name="submit" value="Submit" /></div><br/>
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
