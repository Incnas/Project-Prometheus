<?
//Does what it says on the box. Deletes the entire database... Just kidding, it creates a new calender

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['name'])){
	//Add new Address
	$query = "INSERT into `calender` (name, start_date, end_date, school_week) VALUES (?,?,?,?)";
	$stmt = $mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->bind_param('ssss', $_GET['name'], $_GET['start_date'], $_GET['end_date'], $_GET['school_week']);
	$stmt->execute();
	$stmt->close();
	echo 'Success';
}
else {
?>
<form name="new_week">
	<table>
		<tr>
			<td>Name</td>
		</tr>
		<tr>
			<td>Start Date:</td>
			<td><input type="date" size="30" name="start_date" /></td>
		</tr>
		<tr>
			<td>

</form>

<?
}

?>
