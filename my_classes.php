<?
	//Root index.php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
	if($_SESSION['user']['role']=='student'){
		$query = "SELECT * FROM class JOIN student_class ON class.class_code = student_class.class_code JOIN student ON student_class.student_code = student.student_code JOIN unit ON class.unit_code = unit.unit_code JOIN teacher ON class.teacher_code = teacher.username WHERE student.username = ".$_SESSION['user']['name']." ORDER BY line";
	}
	elseif($_SESSION['user']['role']=='teacher'){
		$query = "SELECT * FROM class JOIN teacher ON class.teacher_code = teacher.username JOIN unit ON class.unit_code = unit.unit_code WHERE username = '{$_SESSION['user']['name']}' ORDER BY line";
	}
	else{
		$query= "SELECT 0";
	}
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
?>
<h2>My Classes</h2>
<hr>
<div id="tabs">
	<ul class="tabs_list">
		<? while($stmt->fetch()) { ?>
			<li><a href="<?='#'.$row['class_code']; ?>"><?=$row['line'].': '.$row['short_name']?></a></li>
		<?}?>
	</ul>
<?
	$stmt->data_seek(0);
	while($stmt->fetch()){
		$query = "SELECT * FROM assessment_item WHERE unit_code=?";
		$stmt2 = $mysqli->prepare($query);
		$stmt2->bind_param('s',$row['unit_code']);
		$stmt2->execute();
		$row2=bind_result_array($stmt2);
?>
<div id="<?=$row['class_code']?>">
	<h3 id="course_title"><?=$row['name'].' - Line: '.$row['line']; ?></h3>
	<div id="class_tabs">
	
		<div id="home">
			<p><b>Teacher:</b> <?=$row['fname'].' '.$row['lname']; ?></p>

			<!--Should display only if the user is a teacher or admin-->
			<? if($_SESSION['user']['role']=='teacher'){ ?>
				<a href='/edit_info.php?unit_code=<?=$row["unit_code"]?>'>Edit</a>
			<? } ?>

			<!--Implement Unit Outline Generator--><a href="unit_outline.php?id=<?=$row['unit_code']?>">View Unit Outline</a> 
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
						<? if ($row2['type']=='Test Week'){ ?>
							<td>Test Week</td>
							<td>Test Week</td>	
						<? }
							elseif ($row2['type']=='Ongoing'){
						?>
							<td>Ongoing</td>
							<td>Ongoing</td>
						<? }
							elseif ($row2['type']=='Date'){
						?>
							<td><?=$row2['out_date'];?></td>
							<td><?=$row2['due_date'];?></td>
						<? } ?>
							</tr>
						<?
							}
							$stmt2->close();
						?>
				</table>
			</div>
		</div>
		<div id="details">
		
		</div>
		<div id="resources">
		
		</div>
	</div>
</div>
<?
}
$stmt->close();
?>
</div>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
</script>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?> 	
