<?
//Displays form and updates assessment in db

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['name'])){
	//Update assessment db
	$query = "UPDATE `assessment_item` set name = ?, weighting = ?, out_date = ?, due_date = ? WHERE id = ?";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('sissi', $_GET['name'], $_GET['weighting'], $_GET['out_date'], $_GET['due_date'], $_GET['id']);
	$stmt->execute();
	$stmt->close();
	echo 'Success';
}
// Get assessment details
$query="SELECT * from assessment_item where id = ? LIMIT 1";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('i', $_GET['id']);
$stmt->execute();
$row=bind_result_array($stmt);
if($stmt->fetch()){
	//display form
	?>
	<form name="assessment_edit">
	<input type="hidden" name="id" value="<?=$row['id']?>" />
	<table>
		<tr>
			<td>Name:</td>
			<td><input type="text" size="30" name="name" value="<?=$row['name']?>" /></td>
		</tr>
		<tr>
			<td>Weighting:</td>
			<td><input type="text" size="30" name="weighting" value="<?=$row['weighting']?>" /></td>
		</tr>

		<tr>
			<td>Out Date:</td>
			<td><input type="text" size="30" name="out_date" value="<?=$row['out_date']?>" /></td>
		</tr>
		<tr>
			<td>Due Date:</td>
			<td><input type="text" size="30" name="due_date" value="<?=$row['due_date']?>" /></td>
		</tr>
	</table>
	</form>
	<?
	}
	else {
		echo "An error has occurred. Please contact the Administrator.";
	}
?>
