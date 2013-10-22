<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

$query="SELECT * FROM student ORDER BY `student_code`";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$row=bind_result_array($stmt);
?>
<button id="add_student">Add Student</button>
<div class="datagrid">
	<table>
		<thead>
			<tr>
				<th>Student ID</th>				
				<th>Student Code</th>
			</tr>
		</thead>
		<tbody>
		<?
			while($stmt->fetch()){
				echo '<tr>';
				echo '<td>'.$row['username'].'</td>';	
				echo '<td>'.$row['student_code'].'</td>';
				echo '</tr>';
			}
			$stmt->close();
		?>
		</tbody>
	</table>
</div>

<div class="new_student">
</div>


<script>
$(function(){
	$('#add_student').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_student.php';
		$('div.new_student').load(path).dialog('open');
	})
	
	$('div.new_student').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "New Student",
		buttons: {
			"Add Student": function() {
				//Add new address
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/new_student.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	})
});


</script>
