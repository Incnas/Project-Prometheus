<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');

if(isset($_GET['fname'])){
	$query = "INSERT into `teacher` VALUES(NULL, ?, '', ?, ?)";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('sss', $_GET['username'], $_GET['fname'], $_GET['lname']);
	$stmt->execute();
	$stmt->close();
	echo 'Success';
}
else {
?>
<form name="new_teacher">
	<table>
		<tr>
			<td>First Name:</td>
			<td><input type="text" size="30" name="fname" /></td>
		</tr>
		<tr>
			<td>Last Name: </td>
			<td><input type="text" size="30" name="lname" /></td>
		</tr>
		<tr>
			<td>Teacher Code:</td>
			<td><input type="text" size="30" name="username" /></td>
		</tr>
	</table>
</form>

<?
}
?>
