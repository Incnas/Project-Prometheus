<?
//Deletes a assessment from the database

$reqadmin=true; // Also needs admin access
include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');


$query="DELETE FROM assessment_items where id=?";
if($stmt=$mysqli->prepare($query)){
	$stmt->bind_param('i', $_GET['id']);
	$stmt->execute();
	echo 'Success';
}
else 
echo 'An error occurred. Please contact the administrator';
	   
?>
