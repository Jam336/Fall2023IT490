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
	die(header("Location: home.html"));
}
echo json_encode($response);
exit(0);

?>
