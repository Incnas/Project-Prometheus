
<?
	//Root index.php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

	$query = "SELECT * FROM calender";
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
?>

<h3>Upload Class Lists</h3>
<h3>Upload Student List</h3>
<h3>Upload Teacher List</h3>
<h3>Upload Student Classes</h3>
<h3>Upload Teacher Classes</h3>
<h3>Upload Calender</h3>
<h4>Edit Calender</h4>
<form action="">
	<input type="checkbox" name="weekends" value="weekEnds">Display Weekends<br>
</form>
<p>Option Display Calender</p>
<p>Display Calender Here</p>
<button class="new">Add Week</button>
<div class='datagrid'>
	<table>
		<thead>
			<tr>
				<th>Week Num</th>
				<th>Monday</th>
				<th>Tuesday</th>
				<th>Wednesday</th>
				<th>Thursday</th>
				<th>Friday</th>
			</tr>
		</thead>
	<tbody>
	<?
		while($stmt->fetch()){
	?>
			<tr>
				<td><button class="day"><?=$row['name'];?></button></td>
			</tr>	
	<?
		}
	?>
	</tbody>
	</table>
</div>

<p>Add New Week</p>


<?
	include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
<div class="new_week"></div>
<script>
// New Assessment Button
	$('button.new').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_week.php?unit_code='+$(this).attr('id');
		$('div.new_week').load(path).dialog('open');
	})
	
	$('div.new_week').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "New Week",
		buttons: {
			"Add week": function() {
				//Add new address
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/new_week.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	})

})
</script>
