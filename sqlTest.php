#!/usr/bin/php
<?php

$server = "192.168.192.11";
$uname = "rabbitMQ";
$pass = "it490";
$DB = "StockDB";

try
{

	$connect = new mysqli($server, $uname, $pass, $DB);
}
catch(mysqli_mysql_exception $err)
{
	echo ("conncection failing");
}


if ($connect->connect_error)
{
	die("Connection failed: " . $connect->connect_error);
}

$sql = "SELECT * FROM Users";
$result = $connect->query($sql);

if ($result->num_rows > 0)
{
	while ($row = $result->fetch_assoc())
	{
		var_dump($row);
		//echo("name: " . $row["username"] . "\n");
	}
}
else
{
	echo "no results";
}

$connect->close();
?>
