<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');

$query = "SELECT * FROM class JOIN user ON class.teacher_code = user.username JOIN unit ON class.unit_code = unit.unit_code";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);
?>
<h1>My Classes</h1>
<?
while($stmt->fetch()){
	$query = "SELECT * FROM assessment_item WHERE unit_code=?";
	$stmt2 = $mysqli->prepare($query);
	$stmt2->bind_param('s',$row['unit_code']);
	$stmt2->execute();
	$row2=bind_result_array($stmt2);
?>
<h4><?=$row['name'].' - Line: '.$row['line']; ?></h4>
<p><b>Teacher:</b> <?=$row['fname'].' '.$row['lname']; ?></p>
<p><b>Resources:</b></p>
<a href='/edit_info.php?unit_code=<?=$row["unit_code"]?>'>Edit</a>
<p><b>Assessments: </b></p>
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
	<td><?=$row2['out_date']; ?></td>
	<td><?=$row2['due_date']; ?></td>
	</tr>
<?
	}
	$stmt2->close();
?>
</table>
</div>
<button type="button">Expand</button>
<?
}
$stmt->close();
?>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
