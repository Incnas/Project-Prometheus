<?
//Does what it says on the box. Deletes the entire database... Just kidding, it adds a new week

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['num_weeks'])){
	//Add new Address
	$query2 = "SELECT * FROM `calender` ORDER BY week_num DESC LIMIT 1";
	$stmt2=$mysqli->prepare($query2);
	$stmt2->execute();
	$stmt2->store_result();
	$row=bind_result_array($stmt2);
	$stmt2->fetch();
	
	for($counter = 1; $counter <= $_GET['num_weeks']; $counter++){
		for($i = 0; $i <=5; $i++){
			$query = "INSERT INTO `calender` (`id`, `week_num`, `day_num`, `type`, `notes`) VALUES (NULL, ?, ?, ?, ?)";
			$stmt = $mysqli->prepare($query);
			echo $mysqli->error;
			$stmt->bind_param('iiss', $a=($row['week_num']+$counter), $i, $_GET['type'], $_GET['notes']);
			$stmt->execute();
			$stmt->close();
		}
	}
	echo 'Success';
	/*
	$query = "INSERT into 'calender' (week_num, day_num, type, notes) VALUES(1, 1, 'School', 'hmm')";
	$stmt = $mysqli-prepare($query);
	echo $mysqli->error;
	$stmt->execute();
	$stmt-close();
	echo 'Success';*/
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
			<td><?$type=select_enum('type','calender', $mysqli)?></td>
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
