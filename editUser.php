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
		$id = $_POST['emp_id'];
		
		$emp_query = "SELECT * FROM Employees WHERE emp_id = '$id'";
		$emp_result = mysqli_query($connection, $emp_query);
		if (!$emp_result) {
			die("You enter wrong employee ID ,please try again."); // bad query syntax error
		}
		else if (mysqli_num_rows($emp_result) != 1) {
		  die("You enter wrong employee ID ,please try again."); 
	  }
		
		
		$emp_row = mysqli_fetch_assoc($emp_result);
		$name = $emp_row['emp_name'];
		$street = $emp_row['emp_address_street'];
		$city = $emp_row['emp_address_city'];
		$state = $emp_row['emp_address_state'];
		$zip = $emp_row['emp_address_zip'];
		$email = $emp_row['email'];
		
		$sales_query = "SELECT *  FROM Salesperson WHERE salesperson_id = '$id'";
		$sales_result = mysqli_query($connection, $sales_query);
		if (!$sales_result) {
			die("You enter wrong employee ID ,please try again."); // bad query syntax error
		}
		else if (mysqli_num_rows($sales_result) != 1) {
		  die("You enter wrong product ID ,please try again."); 
	  }
		
		
		$sales_row = mysqli_fetch_assoc($sales_result);
		$store = $sales_row['store_id'];
		$title = $sales_row['title'];
		$salary = $sales_row['salary'];
	}
?>
<?php
	if(isset($_POST['submit'])) {
		$id2 = $_POST['emp_id'];
		$name2 = $_POST['emp_name'];
		$street2 = $_POST['emp_address_street'];
		$city2 = $_POST['emp_address_city'];
		$state2 = $_POST['emp_address_state'];
		$zip2 = $_POST['emp_address_zip'];
		$email2 = $_POST['email'];
		
		$title2 = $_POST['title'];
		$store2 = $_POST['store_id'];
		$salary2 = $_POST['salary'];
		
		$update_emp_query = "UPDATE Employees SET emp_name = '$name2', emp_address_street = '$street2', emp_address_city = '$city2', emp_address_state = '$state2', emp_address_zip = '$zip2', email = '$email2' WHERE emp_id = '$id2'";
		
		$update_emp_result = mysqli_query($connection, $update_emp_query);
		
		if ($update_emp_result) {
			echo "Successfully updated employee " . $id . "; ";
		} else {
			print_r($_POST);
			die("Database query failed. " . mysqli_error($connection) . " ");
		}
		
		$update_sales_query = "UPDATE Salesperson SET store_id = '$store2', title = '$title2', salary = '$salary2'WHERE salesperson_id = '$id2'";
		
		$update_sales_result = mysqli_query($connection, $update_sales_query);
		
		if ($update_sales_result) {
			echo "Successfully updated salesperson " . $id;
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
	<h2>Edit Employee</h2>
	<form action="editUser.php" method="post">
		<h2>
			Employee Details: 
		</h2>
		<div>
			<label for="emp_id">Employee ID: </label><br/>
			<input type="text" name="emp_id" value="<?php echo $id;?>" /><br/>
		</div>
		<div>
			<label for="emp_name">Name: </label><br/>
			<input type="text" name="emp_name" value="<?php echo $name;?>" /><br/>
		</div>
		<div>
			<label for="emp_address_street">Street: </label><br/>
			<input type="text" name="emp_address_street" value="<?php echo $street;?>" /><br/>
		</div>
		<div>
			<label for="emp_address_city">City: </label><br/>
			<input type="text" name="emp_address_city" value="<?php echo $city;?>" /><br/>
		</div>
		<div>
			<label for="emp_address_state">State: </label><br/>
			<input type="text" name="emp_address_state" value="<?php echo $state;?>" /><br/>
		</div>
		<div>
			<label for="emp_address_zip">Zip: </label><br/>
			<input type="text" name="emp_address_zip" value="<?php echo $zip;?>" /><br/>
		</div>
		<div>
			<label for="email">Email: </label><br/>
			<input type="text" name="email" value="<?php echo $email;?>" /><br/>
		</div>
		<h2>
			Salesperson Details:
		</h2>
		<div>
			<label for="title">Title: </label><br/>
			<input type="text" name="title" value="<?php echo $title;?>" /><br/>
		</div>
		<div>
			<label for="store_id">Store ID: </label><br/>
			<input type="text" name="store_id" value="<?php echo $store;?>" /><br/>
		</div>
		<div>
			<label for="salary">Salary: </label><br/>
			<input type="text" name="salary" value="<?php echo $salary;?>" /><br/>
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

