<?
//Displays form and updates assessment in db

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_GET['session_name_input'])&&isset($_GET['start_date'])){
	//Update assessment db
	$query = "UPDATE `option` set data = ? WHERE name='session_name'";
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param('s', $_GET['session_name_input']);
	$stmt->execute();
	$stmt->close();
	
	$query2 = "UPDATE `option` set data = ? WHERE name='session_start_date'";
	$stmt2 = $mysqli->prepare($query2);
	$stmt2->bind_param('s', $_GET['start_date']);
	$stmt2->execute();
	$stmt2->close();
	echo 'Success';
}
// Get assessment details
$query="SELECT * FROM `option` WHERE name='session_name'";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);

$query2="SELECT * FROM `option` WHERE name='session_start_date'";
$stmt2=$mysqli->prepare($query2);
$stmt2->execute();
$stmt2->store_result();
$row2=bind_result_array($stmt2);
$stmt2->fetch();

if($stmt->fetch()){
	//display form
	?>
	<form name="session_edit">
	<table>
		<tr>
			<td>Session Name: <input type="text" name="session_name_input" value="<?=$row['data']?>"/></td>
		</tr>
		<tr>
			<td>Start Date: <input type="date" name="start_date" value="<?=$row2['data']?>"></td>
		</tr>
	</table>
	</form>
	<?
	}
	else {
		echo "An error has occurred. Please contact the Administrator.";
	}
?>
