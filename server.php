#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');
require_once('login.php.inc');

function sqlRequest($query){
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

//ql = "SELECT * FROM Users";
$result = $connect->query($query);

$connect->close();


return $result;


}




function doLogin($username,$password)
{
    // lookup username in databas
    // check password
    $login = new loginDB();
    return $login->validateLogin($username,$password);
    //return false if not valid
}

function sqlTest()
{

	$results = sqlRequest("Select * FROM Users");

	var_dump($results);



}

function requestProcessor($request)
{

  $outArray = 0;
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "Login":
      $output = doLogin($request['username'],$request['password']);
      $outArray = array("returnCode" => $output, 'message' => 'login request recieved', 'username' => $request['username']);
      break;	
      return doLogin($request['username'],$request['password']);
     


    case "validate_session":
	    return doValidate($request['sessionId']);
	    break;
    case "SqlTest":
	   echo "test"; 
	   return sqlTest();
	   break;

	

  }
  if($outArray != 0)
  {
  	return $outArray;
  }
  return array("returnCode" => '0', 'message'=>"Server received request and processed", "test" => 'salad');
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

sqlTest();

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;

//sqlTest();

exit();
?>

