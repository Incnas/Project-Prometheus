<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
//include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');

$query = "SELECT * FROM unit JOIN class ON unit.unit_code=class.unit_code JOIN teacher ON class.teacher_code = teacher.username WHERE unit.unit_code=? limit 1";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s',$_GET['unit_code']);
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);
$stmt->fetch();

$query = "SELECT * FROM class JOIN teacher ON teacher.username=class.teacher_code WHERE unit_code=?";
$stmt2=$mysqli->prepare($query);
$stmt2->bind_param('s',$row['unit_code']);
$stmt2->execute();
$stmt2->store_result();
$row2=bind_result_array($stmt2);
?>
<div class='section'>
<h4><?=$row['name']?></h4>
<h4>Unit Code: <?=$_GET['unit_code']?></h4>
<h4>Line: </h4>
<?
$stmt2->data_seek(0);
while($stmt2->fetch()){
	echo $row2['line'].', ';
}
?>
<h4>Teacher(s): </h4>
<?
$stmt2->data_seek(0);
while($stmt2->fetch()){
	echo $row2['fname'].' '.$row2['lname'].' ('.$row2['class_code'].')'.', ';
}
?>

<h4>Unit Goals:</h4>
<?
$goals=txt2array($row['goals']);
foreach($goals as $goal){
	echo '<li>'.$goal['text'].'</li>';
}	
?>
	
<h4>Content:</h4>
<?
$goals=txt2array($row['content']);
foreach($goals as $goal){
	echo '<li>'.$goal['text'].'</li>';
}	
?>

<div class='datagrid'>
<table>
<thead>
	<tr>
		<th>Name</th>
		<th>Weighting</th>
		<th>Out Date</th>
		<th>Due Date</th>
	</tr>
</thead>

<? 
$stmt->close();

$query="SELECT * FROM assessment_item where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s', $_GET['unit_code']);
$stmt->execute();
$row=bind_result_array($stmt);
?>

<tbody>
	<? while($stmt->fetch()){
		?>
	<tr>
		<td><?=$row['name'];?></td>
		<td><?=$row['weighting'];?></td>
		<? if ($row['type']=='Test Week'){ ?>
			<td>Test Week</td>
			<td>Test Week</td>	
		<? }
			elseif ($row['type']=='Ongoing'){
		?>
			<td>Ongoing</td>
			<td>Ongoing</td>
		<? }
			elseif ($row['type']=='Date'){
		?>
			<td><?=$row['out_date'];?></td>
			<td><?=$row['due_date'];?></td>
		<? } ?>
	</tr>	
	<?
	}
	?>	
</tbody>
</table>
</div>

</div>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
