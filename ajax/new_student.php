<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');

if(isset($_GET['username'])){
	$query = "INSERT into `student` VALUES(NULL, ?, '', ?)";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('sss', $_GET['username'], $_GET['student_code']);
	$stmt->execute();
	$stmt->close();
	echo 'Success';
}
else {
?>
<form name="new_student">
	<table>
		<tr>
			<td>Student ID:</td>
			<td><input type="text" size="30" name="username" /></td>
		</tr>
		<tr>
			<td>Student Code:</td>
			<td><input type="text" size="30" name="student_code" /></td>
		</tr>
		
	</table>
</form>

<?
}
?>
