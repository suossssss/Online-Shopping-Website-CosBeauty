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
 
  if(isset($_POST['manager_login'])){
  	  $login_id = $_POST['emp_id'];
	  $login_query = "SELECT Temp.emp_id FROM (select distinct emp_id from Employees,Store,Region where emp_id=manager or emp_id= region_manager) as Temp  WHERE Temp.emp_id=$login_id";
	  $login_result = mysqli_query($connection, $login_query);
	  if (!$login_result) {
		  header("Location: bad_login.php"); // bad query syntax
	  } else if (mysqli_num_rows($login_result) != 1) {
		  header("Location: bad_login.php");
	  }
  }

 
?>
<?php
	$max_query = "SELECT MAX(emp_id) FROM Employees";
	
	$max_result = mysqli_query($connection, $max_query);
	if (!$max_result) {
		die("Database query failed."); // bad query syntax error
	}
	
	$max_row = mysqli_fetch_assoc($max_result);
	$max = $max_row["MAX(emp_id)"];
	$new_id = $max + 1;
?>
<?php
	if(isset($_POST['submit'])){
		$id = $_POST['emp_id'];
		$name = $_POST['emp_name'];
		$street = $_POST['emp_address_street'];
		$city = $_POST['emp_address_city'];
		$state = $_POST['emp_address_state'];
		$zip = $_POST['emp_address_zip'];
		$email = $_POST['email'];
		
		$title = $_POST['title'];
		$store = $_POST['store_id'];
		$salary = $_POST['salary'];
		
		$add_emp = "INSERT INTO Employees VALUES ('$id', '$name', '$street', '$city', '$state', '$zip', '$email')";
		
		$add_emp_result = mysqli_query($connection, $add_emp);
		if ($add_emp_result) {
			echo "Successfully added employee " . $id . "; "; 
		} else {
			die("Database query failed. " . mysqli_error($connection));
		}
		$_POST['salesperson_id']=$_POST['emp_id'];
		$id1 = $_POST['salesperson_id'];
		$add_sales = "INSERT INTO Salesperson VALUES ('$id1' , '$title', '$salary','$store')";
		$add_sales_result = mysqli_query($connection, $add_sales);
		if ($add_sales_result) {
			echo "Successfully added salesperson " . $id; 
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
	<h2>Add Employee</h2>
	<form action="addUser.php" method="post">
		<h2>
			Employee Details: 
		</h2>
		<div>
			<label for="emp_id">Employee ID: </label><br/>
			<input type="text" name="emp_id" value="<?php echo $new_id;?>" /><br/>
		</div>
		<div>
			<label for="emp_name">Name: </label><br/>
			<input type="text" name="emp_name" /><br/>
		</div>
		<div>
			<label for="emp_address_street">Street: </label><br/>
			<input type="text" name="emp_address_street" /><br/>
		</div>
		<div>
			<label for="emp_address_city">City: </label><br/>
			<input type="text" name="emp_address_city" /><br/>
		</div>
		<div>
			<label for="emp_address_state">State: </label><br/>
			<input type="text" name="emp_address_state" /><br/>
		</div>
		<div>
			<label for="emp_address_zip">Zip: </label><br/>
			<input type="text" name="emp_address_zip" /><br/>
		</div>
		<div>
			<label for="email">Email: </label><br/>
			<input type="text" name="email" /><br/>
		</div>
		
		<h2>
			Salesperson Details:
		</h2>
		<div>
			<label for="title">Title: </label><br/>
			<input type="text" name="title" /><br/>
		</div>
		<div>
			<label for="store_id">Store ID: </label><br/>
			<input type="text" name="store_id" /><br/>
		</div>
		<div>
			<label for="salary">Salary: </label><br/>
			<input type="text" name="salary" /><br/>
		</div>
		<div><input type="submit" name="submit" value="Submit"><br/></div>
		
	</form>
	<h2>
		To edit an employee, enter the 
		employee ID below and click "Search"
	</h2>
	<form action="editUser.php" method="post">
		<label for="emp_id">Employee ID: </label><br/>
		<input type="text" name="emp_id" /><br/>
		<input type="submit" name="search" value="Search"><br/>
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