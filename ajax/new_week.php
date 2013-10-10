<?
//Does what it says on the box. Deletes the entire database... Just kidding, it adds a new week

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['name'])){
	$last_date=$_GET['start_date'];
	$query = "SELECT * FROM calender ORDER BY id DESC LIMIT 1";
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
	if($stmt->fetch()){
		$last_date=$row['date'];
	}
	//Add new Address
	foreach($_GET['num_weeks'] as $counter){
		for($i = 0; $i <=5; $i++){
			$query = "INSERT into `calender` (name, start_date, end_date, school_week) VALUES (?,?,?,?)";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('ssss', $_GET['name'], $_GET['start_date'], $_GET['end_date'], $_GET['school_week']);
			$stmt->execute();
			$stmt->close();
			echo 'Success';
		}
	}
}
else {
?>
<form name="new_week">
	<table>
		<tr>
			<td>Number of Weeks:</td>
			<td><input type="text" size="30" name="num_weeks" value="1"/></td>
		</tr>
		<tr>
			<td>Type</td>
			<td><?select_enum('type','calender', $mysqli)?></td>
		</tr>
		<tr>
			<td>Notes:</td>
			<td><input type="text" size="30" name="notes" /></td>
		</tr>
	</table>

</form>

<?
}

?>
