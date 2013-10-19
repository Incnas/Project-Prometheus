<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

$query = "SELECT * FROM class JOIN teacher ON class.teacher_code = teacher.username JOIN unit ON class.unit_code = unit.unit_code ORDER BY `class_code`";
$stmt=$mysqli->prepare($query);	
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);
?>
<h3>Insert Search Bar Here</h3>
<div class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Class Code</th>
				<th>Class Name</th>
				<th>Line</th>
				<th>Teacher</th>
			</tr>
		</thead>
		<tbody>
			<?
			while($stmt->fetch()){
			?>
			<tr>
				<td><?=$row['class_code']?></td>
				<td><?=$row['name']?></td>
				<td><?=$row['line']?></td>
				<td><?=$row['fname'].' '.$row['lname']?></td>
			</tr>
			<?	
			}
			?>
		</tbody>
	</table>
</div>

<?
/*
while($stmt->fetch()){
	$query = "SELECT * FROM assessment_item WHERE unit_code=?";
	$stmt2 = $mysqli->prepare($query);
	$stmt2->bind_param('s',$row['unit_code']);
	$stmt2->execute();
	$row2=bind_result_array($stmt2);
?>
<h4><?=$row['name'].' - Line: '.$row['line']; ?></h4>
<p><b>Teacher:</b> <?=$row['fname'].' '.$row['lname']; ?></p>
<!-- <p><b>Assessments: </b></p>
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
	while($stmt2->fetch()){
?>
	<tr>
	<td><?=$row2['name']; ?> </td>
	<td><?=$row2['weighting']; ?></td>
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
	$stmt2->close();
?>
</table>
</div> -->
<?
}
$stmt->close();
?>

<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
