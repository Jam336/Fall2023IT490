<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Login</h2>
  </div>
	 
  <form method="post" action="login.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  		<label>Username</label>
  		<input type="text" name="username" >
  	</div>
  	<div class="input-group">
  		<label>Password</label>
  		<input type="password" name="password">
  	</div>
  	<div class="input-group">
  		<button type="submit" class="btn" name="login_user">Login</button>
  	</div>
  	<p>
  		Not yet a member? <a href="register.php">Sign up</a>
  	</p>
  </form>
</body>
</html>

<?php

	$server = "192.168.192.11";
	$user = "rabbitMQ";
	$pass = "it490";
	$DB = "StockDB";

	if (isset($_POST["username"]) && isset($_POST["password"]))
	{
		$error = false;
		$username = $_POST["username"];
		$password = $_POST["password"];

		if (empty($username))
		{
			echo ("no username entered");
			$error = true;
		}
		if (empty($password))
		{
			echo ("no password entered");
			$error = true;
		}

		if (!$error)
		{
			try
			{
				$connect = new mysqli($server, $uname, $pass, $DB);
			}
			catch (mysqli_mysql_exception $err)
			{
				echo ("issue connecting to database");
			}


			if ($connect->connect_error)
			{
				die ("Connection failed " . $connect->connect_error);
			}

			$statement = $connect->prepare("SELECT userID, username, password from Users where username = :username");

			try
			{
				$ex = statement->execute([":username" = $username]);

				if ($ex)
				{
					$user = $statement->fetch(PDO::FETCH_ASSOC);

					if (!$user)
					{
						echo ("Invalid username");
					}
				}
			}
			catch (exception e)
			{
				echo (var_export($e, true);
			}
		}
	}
?>
