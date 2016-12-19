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
						<h1>Welcome :)</h1>
						<form action="addCust.php" method="post">
							<p>
								<b>Sign Up OR Edit customer Infomation:</b>
							</p>
							
							<input type="submit" name="login" value="Add/Edit Customer"/>
						</form>

						<form action="account.php" method="post">
							<p>
								<b>View Account Balance:</b>
							</p>
							<label for="customer_id">Customer ID: </label>
							<input type="text" name="customer_id" />
							<input type="submit" name="submit">
						</form>

						<form action="prod_results.php" method="post">
							<p>
								<b>View All Products:</b>
							</p>
							<input type="submit" name="browse" value="Browse">
						</form>
						<form action="addTrans.php" method="post">
							<p>
								<b>Add Orders:</b>
							</p>
							<label for="customer_id">Customer ID: </label>
							<input type="text" name="customer_id" />
							<input type="submit" name="login" value="Add Transaction" />
							</form>
						


						<p>or</p>

						<form action="prod_results.php" method="post">
							<p>Search for a Product:</p>
							<div>
								<label for="product_name">Name:</label>
								<input type="text" name="product_name" />
							</div>
							
							<div>
								<label for="product_type">Type:</label>
								<select name="product_type">
									<option value="">Select Type</option>
									<option value="makeup">MakeUp</option>
									<option value="skincare">SkinCare</option>
									<option value="Fragrance">Fragrance</option>
									<option value="Bath&Body">Bath&Body</option>
									<option value="Nails">Nails</option>
									<option value="Hair">Hair</option>
									<option value="Brushes">Brushes</option>
				
								</select>
							</div>
							<div>
								<input type="submit" name="search" value="Search"/>
							</div>
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