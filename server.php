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

  if (!isset($result))
{
	echo "No data";

  }    
    
$connect->close();


return $result;


}




function generateToken($userID)
{
	
	$str = rand();
	$token = hash("sha256" , $str);

	//$token = "token";
	$statement = "INSERT INTO Tokens (userID,token) VALUES (" . $userID . ", '" . $token . "');";
	$result = sqlRequest($statement);
	





	return($token);
}

function login($username, $password)
{

	$statement = "SELECT userID, username, password FROM Users WHERE username = '" . $username . "' AND password = '" . $password . "'";
	$result = sqlRequest($statement);
	$row = $result->fetch_assoc();

	var_dump($result);
	if(!isset($row))
	{
	echo "No results!\n";
	return "No results!";

	}

	//echo($result['num_rows']);

	$out = 
	[
		"userID" => $row['userID'],
		"token" => generateToken($row['userID'])
	];	
	
	return($out);

}

function register($username, $password)
{
	$statement = "insert into Users(username, password) values('" . $username . "','" . $password . "')";
	$result = sqlRequest($statement);
	return($result);
}

function sqlTest()
{

	$results = sqlRequest("Select * FROM Users");

	var_dump($results);

}

function logout($userID, $token){

	//Simple token deletion
	$statement = "Delete FROM Tokens WHERE userID = " . $userID
		. " AND token = '" . $token . "'";
	
	$result = sqlRequest($statement);

	echo "token deleted\n";

	return $result;

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
    case "login":
     // $output = login($request['username'],$request['password']);
     // $outArray = array("returnCode" => $output, 'message' => 'login request recieved', 'username' => $request['username']);
	    // return (login($request['username'],$request['password']));
	return login($request['username'], $request['password']);
      break;
     


    case "validate_session":
	    return doValidate($request['sessionId']);
	    break;
    case "SqlTest":
	   echo "test"; 
	   return sqlTest();
	   break;

    case "logout":
 	echo "Logging out...\n";
    	return logout($request['userID'], $request['token']);
	break;	

  }
  if($outArray != 0)
  {
  	return $outArray;
  }
 return array("returnCode" => '0', 'message'=>"Server received request and processed", "test" => 'salad');
}

$server = new rabbitMQServer("testRabbitMQ.ini","testServer");


//$username = "Joey2";
//$password = "passwd";
//$type = "Login";
/*$request = 
=======
$username = "1";
$password = "token2";
$type = "logout";
$request = 
>>>>>>> a61f64c0066aee886511d821d6884cc710483a32
	[
		"type" => $type,
		"userID"=> $username,
		"token" => $password,
	];
 */
//$bogus = register($username, $password);
//$bogus = requestProcessor($request);
//var_dump($bogus);

echo "testRabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "testRabbitMQServer END".PHP_EOL;

//sqlTest();

exit();
?>

