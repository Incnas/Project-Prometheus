<?
//Does what it says on the box. Deletes the entire database... Just kidding, it adds a new assessment

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['id'])){
	//Add new Address
	$query = "INSERT into `assessment_items` (name, weighting, out_date, due_date) VALUES (?,?,?,?)";
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->bind_param('ssis', $_GET['name'], $_GET['weighting'], $_GET['out_date'], $_GET['due_date']);
	$stmt->execute();
	$stmt->close();
	echo 'Success';
}
else {
?>
<form name="new_assessment">
<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" size="30" name="name" /></td>
		</tr>
		<tr>
			<td>Weighting:</td>
			<td><input type="text" size="30" name="weighting" /></td>
		</tr>

		<tr>
			<td>Out Date:</td>
			<td><input type="text" size="30" name="out_date" /></td>
		</tr>
		<tr>
			<td>Due Date:</td>
			<td><input type="text" size="30" name="due_date" /></td>
		</tr>
	</table>

</form>

<?
}
?>
