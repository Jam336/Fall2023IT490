<?php
require('../client.php');

if (!isset($_POST))
{
	$msg = "NO POST information";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type";
$response = "login request";
$error = false;

if (empty($request["username"])
{
	$response = "No username provided";
	$error = true;
}
if (empty($request["password"])
{
	$response = "No password provided";
	$error = true;
}
if (!$error)
{
	login($request);
	$response = "Successfully sent to client";
}
echo json_encode($response);
exit(0);

?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
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
