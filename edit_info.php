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

$query = "SELECT * FROM class JOIN user ON user.username=class.teacher_code WHERE unit_code=?";
$stmt2=$mysqli->prepare($query);
$stmt2->bind_param('s',$_GET['unit_code']);
$stmt2->execute();
$stmt2->store_result();
$row2=bind_result_array($stmt2);
?>
<div class='section'>
<h4><?=$row['name']?></h4>
<h4>Unit Code: <?=$row['unit_code']?></h4>
<h4>Line(s): </h4>
<?
$stmt2->data_seek(0);
while($stmt2->fetch()){
	echo $row2['line'];
}
?>
<h4>Teacher(s): </h4>
<?
$stmt2->data_seek(0);
while($stmt2->fetch()){
	echo $row2['fname'].' '.$row2['lname'].' ('.$row2['class_code'].')';
}
?>
<form name='input' action="html_form_action.asp" method="post">

<h4>Unit Goals:</h4>
<p>Note: Each New Line Is An Individual Entry</p>
<textarea>
Test Text Area. NOTE:THE SIZE IS CHANGABLE. NEEDS FIX
</textarea>

<h4>Content:</h4>
<p>Note: Each New Line Is An Individual Entry</p>
<textarea>
Test Text Area. NOTE:THE SIZE IS CHANGABLE. NEEDS FIX
</textarea>

<? 
$stmt->close();
$stmt2->close();


$query="SELECT * FROM assessment_item where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s', $_GET['unit_code']);
$stmt->execute();
$row=bind_result_array($stmt);


?>

<h4>Assessment Items:</h4><button class="new" type="button">Add Assessment</button>
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
<tbody>
	<? while($stmt->fetch()){
		?>
	<tr>
		<td><?=$row['name'];?></td>
		<td><?=$row['weighting'];?></td>
		<td><?=$row['out_date'];?></td>
		<td><?=$row['due_date'];?></td>
		<td><button class="edit" id= <?=$row['id'] ?> >Edit</button></td>
		<td><button class="delete" id= <?=$row['id'] ?> >Delete</button></td>
	</tr>	
<?
}
?>	
</tbody>
</table>
</div>

<button type="reset" value="Reset">Reset</button>
<button type="button">Default</button>
<input type="submit" formaction="preview_template" value="Preview" />
<input type="submit" value="Submit" />
</form>
</div>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>

<script>
//Edit assessment Button
$(function(){
	$('button.edit').button({
		icons:{primary: "ui-icon-pencil"}
	}).click(function(){
		var path = '/ajax/edit_assessment.php?id='+$(this).attr('id');
		$('div.edit_assessment').load(path).dialog('open');
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
					location.href = location.pathname;
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
					location.href = location.pathname;
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
		$('div.new_assessment').load('/ajax/new_assessment.php').dialog('open');
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
					location.href = location.pathname;
				});
			}
		}
	})

})
</script>
