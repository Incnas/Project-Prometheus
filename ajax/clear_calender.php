<?
//Deletes a assessment from the database

$reqadmin=true; // Also needs admin access
include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');


$query="TRUNCATE TABLE calender";
if($stmt=$mysqli->prepare($query)){
	$stmt->execute();
	echo 'Success';
}
else 
echo 'An error occurred. Please contact the administrator';
	   
?>
