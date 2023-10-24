#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");

/*
$request = array();
$request['type'] = "login";
$request['username'] = $argv[1];
$request['password'] = $argv[2];
$request['message'] = "HI";
$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;
 */

function login ($username, $password)
{
	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");

	$request =
        [
                "type" => "login",
                "username"=> $username,
                "password" => $password,
        ];
	$response = $client->send_request($request);
	return ($response);
}

function register ($username, $password)
{
	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	$request =
        [
                "type" => "register",
                "username"=> $username,
                "password" => $password,
        ];

	$response = $client->send_requesr($request);
	return ($response);

}

function logout ($userID, $token)
{
	$client = new rabbitMQClient("testRabbitMQ.ini", "testServer");
	$request =
        [
                "type" => "logout",
                "userID"=> $userID,
                "token" => $token,
        ];

	$response = $client->send_requesr($request);
	return ($response);

}


$username = "Joey2";
$password = "passwd";
$bogus = login($username, $password);
var_dump($bogus);
