<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

$query="SELECT * FROM teacher ORDER BY `username`";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$row=bind_result_array($stmt);
?>
<button id="add_teacher">Add Teacher</button>
<div class="datagrid">
	<table>
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last name</th>
				<th>Teacher Code</th>
			</tr>
		</thead>
		<tbody>
		<?
			while($stmt->fetch()){
				echo '<tr>';
				echo '<td>'.$row['fname'].'</td>';
				echo '<td>'.$row['lname'].'</td>';	
				echo '<td>'.$row['username'].'</td>';
				echo '</tr>';
			}
			$stmt->close();
		?>
		</tbody>
	</table>
</div>

<div class="new_teacher">
</div>


<script>
$(function(){
	$('#add_teacher').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_teacher.php';
		$('div.new_teacher').load(path).dialog('open');
	})
	
	$('div.new_teacher').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "New Teacher",
		buttons: {
			"Add Teacher": function() {
				//Add new address
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/new_teacher.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	})
});


</script>