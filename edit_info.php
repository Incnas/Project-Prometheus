<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
//include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');

$query = "SELECT * FROM unit JOIN class ON unit.unit_code=class.unit_code WHERE unit.unit_code=? limit 1";
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

$query = "SELECT * FROM `option` WHERE name='session_name'";
$stmt_option=$mysqli->prepare($query);
$stmt_option->execute();
$stmt_option->store_result();
$row_option=bind_result_array($stmt_option);
$stmt_option->fetch();
?>
<div class='section'>
<h2 class='title'><?=$row['name']?></h2>
<table id='info'>
	<tr><td><h4>Unit Code: </h4><?=$_GET['unit_code']?></td><td><h4>Session: </h4><?=$row_option['data']?></td></tr>
	<tr><td><h4>Line(s): </h4>
		<?
		$stmt2->data_seek(0);
		while($stmt2->fetch()){
			echo $row2['line'].', ';
		}
		?>
	</td><td><h4>Year: </h4><?=date("Y"); ?></td></tr>
	<tr><td><h4>Teacher(s): </h4>
		<?
		$stmt2->data_seek(0);
		while($stmt2->fetch()){
			echo $row2['fname'].' '.$row2['lname'].' ('.$row2['class_code'].')'.', ';
		}
		?>
	</td><td><h4><?=$row['std_units']?> Standard Units</h4></td></tr>
</table>
<hr>
<div class='title'>
	<h4>Unit Goals:</h4>
	<p id='note'>Note: Each New Line Is An Individual Entry</p>
</div>
<textarea>
<?=$row['goals']?>
</textarea>

<hr>
<div class='title'>
	<h4>Content:</h4>
	<p id='note'>Note: Each New Line Is An Individual Entry</p>
</div>
<textarea>
<?=$row['content']?>
</textarea>

<div class='title'><h4>Assessment Items:</h4><button class="new" id="<?=$row['unit_code']?>">Add Assessment</button></div>
<div class='datagrid'>
<table>
<thead>
	<tr>
		<th>Name</th>
		<th>Weighting</th>
		<th>Out Date</th>
		<th>Due Date</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
</thead>

<? 
$stmt->close();
$stmt2->close();


$query="SELECT * FROM assessment_item where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s', $_GET['unit_code']);
$stmt->execute();
$row=bind_result_array($stmt);
?>

<tbody>
	<? while($stmt->fetch()){ ?>
	<tr class='edit_row' id="<?=$row['id'] ?>">
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
		<td><button class="edit" id= "<?=$row['id'] ?>" >Edit</button></td>
		<td><button class="delete" id= "<?=$row['id'] ?>" >Delete</button></td>
	</tr>	
	<?
	}
	?>	
</tbody>
</table>
</div>
<button class='preview'>Preview</button>
<button class='submit'>Submit</button>

</div>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>

<div class="edit_assessment"></div>
<div class="new_assessment"></div>
<div class="delete_assessment"><h1>ARE YOU SURE!!!???!!!</h1></div>
<script>
//Edit assessment Button
$(function(){
	$('button.edit').button({
		icons:{primary: "ui-icon-pencil"}
	}).click(function(){
		var path = '/ajax/edit_assessment.php?id='+$(this).attr('id');
		$('div.edit_assessment').
		load(path).
		dialog('open');
	});
	$('div.edit_assessment').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Edit assessment",
		buttons: {
			"Update Assessment": function() {
				//Update assessment
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/edit_assessment.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	});
	
//Delete Assessment Button	
	$('button.delete').button({
		icons:{primary:"ui-icon-trash"}
	}).click(function(){
		$('div.delete_assessment').dialog('open').attr('id', $(this).attr('id'));
	})
	$('div.delete_assessment').dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Delete Assessment Item?",
		buttons: {
			"Delete": function(){
				var path = "/ajax/delete_assessment.php?id="+$(this).attr('id');
				$.get(path, function(){
					location.href = location.href;
				})
			},
			"Cancel": function(){
				$(this).dialog('close');
			}
		}
	})

// New Assessment Button
	$('button.new').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_assessment.php?unit_code='+$(this).attr('id');
		$('div.new_assessment').load(path).dialog('open');
	})
	
	$('div.new_assessment').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "New assessment",
		buttons: {
			"Add assessment": function() {
				//Add new address
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/new_assessment.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	})
//Submit
	$('button.submit').button({
		//icons:{primary: "ui-icon-closethick"}
	}).click(function(){
		window.location.href='logout.php';
	});
//Preview
	$('button.preview').button({
		//icons:{primary: "ui-icon-closethick"}
	}).click(function(){
		window.location.href='logout.php';
	});
	
//Edit Row
	$('tr.edit').click(function(){
		var path = '/ajax/edit_assessment.php?id='+$(this).attr('id');
		$('div.edit_assessment').
		load(path).
		dialog('open');
	});
	$('div.edit_assessment').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Edit assessment",
		buttons: {
			"Update Assessment": function() {
				//Update assessment
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/edit_assessment.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	});

})
</script>
