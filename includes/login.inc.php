<?
//Most important and critical page of the entire website.

include_once('functions.php');

session_start(); 
if(!isset($reqauth)) $reqauth=true; //default to require auth
if(!isset($reqadmin)) $reqadmin=false; //default to not require admin

//Check if user is authenticated
if($reqauth==true && (!isset($_SESSION['authenticated']) OR $_SESSION['authenticated']!=true)){
	header('Location: /login.php?login=req&path='.$_SERVER['REQUEST_URI']); //redirect to home page
	exit;
}

//Check if user needs to be admin but isn't
if($reqadmin==true && (!isset($_SESSION['user']['isadmin']) OR $_SESSION['user']['isadmin']!=true)){
	header('HTTP/1.0 403 Forbidden');
	echo "Go away you are not allowed here!!";
	exit;
}

//Log in to MySQL database, using mysqli 
$mysqlusername="prometheus";
$mysqlpassword="v3ApJX6YEfXVXKup";
$database="prometheus";

//single most important video in the site. What
$mysqli= new mysqli('localhost', $mysqlusername, $mysqlpassword, $database);

if(mysqli_connect_errno()) {
	//Could not connect to database
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
?>
