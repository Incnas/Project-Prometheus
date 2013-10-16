<?
	//Root index.php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

	$query = "SELECT * FROM calender";
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);

	$query = "SELECT * FROM `option` WHERE name='session_name'";
	$stmt2=$mysqli->prepare($query);
	$stmt2->execute();
	$stmt2->store_result();
	$row2=bind_result_array($stmt2);
	$stmt2->fetch();
	
	$query3 = "SELECT * FROM `option` WHERE name='session_start_date'";
	$stmt3=$mysqli->prepare($query3);
	$stmt3->execute();
	$stmt3->store_result();
	$row3=bind_result_array($stmt3);
	$stmt3->fetch();
?>

<h3>Upload Class Lists</h3>
<h3>Upload Student List</h3>
<h3>Upload Teacher List</h3>
<h3>Upload Student Classes</h3>
<h3>Upload Teacher Classes</h3>
<h3>Upload Calender</h3>
<h4>Edit Calender</h4>
<button class="clear">Clear Calender</button>
<button class="new">Add Week(s)</button>
<button class="delete">Delete Week</button>
<form>
Session Name: <input type="text" name="session_name" value="<?=$row2['data']?>"/><br>
<?
	$stmt2->close();
	$query = "SELECT * FROM `option` WHERE name='session_name'";
	$stmt2=$mysqli->prepare($query);
	$stmt2->execute();
	$stmt2->store_result();
	$row2=bind_result_array($stmt2);
	$stmt2->fetch();
?>
Start Date: <input type="date" name="start_date" value="<?=$row3['data']?>"><br>
<button type='submit'>Submit</button>
</form>
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
		<tr>
	<?
		while($stmt->fetch())
		{
	?>			
			<td><!--<button class="day">Week <?=$row['week_num'];?></button>-->
			<?if($row['day_num']!=0) {
				//echo $row['day_num'].' ';
				echo get_date($row3['data'], ($row['week_num']-1)*5+$row['day_num'])->format('d/M');
			}
			else{
				echo 'Week: '.$row['week_num'].' ';
			}
			
			if($row['type']!='School')
				echo $row['type'];?>
			</td>
	<?
			if($row['day_num']==5){
				?></tr><tr><?
			}
		}
	?>

	</tr>
	</tbody>
	</table>
</div>

<?
	include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
<div class="new_week"></div>
<div class="clear_calender">Are you sure? This move is irreversable.</div>
<div class="delete_week">Are you sure?</div>
<script>
$(function(){
//Clear Calender Button	
	$('button.clear').button({
		icons:{primary:"ui-icon-trash"}
	}).click(function(){
		$('div.clear_calender').dialog('open').attr('id', $(this).attr('id'));
	})
	$('div.clear_calender').dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Clear Calender?",
		buttons: {
			"Delete": function(){
				var path = "/ajax/clear_calender.php?id="+$(this).attr('id');
				$.get(path, function(){
					location.href = location.href;
				})
			},
			"Cancel": function(){
				$(this).dialog('close');
			}
		}
	})
//Delete Weeks Button	
	$('button.delete').button({
		icons:{primary:"ui-icon-trash"}
	}).click(function(){
		$('div.delete_week').dialog('open').attr('id', $(this).attr('id'));
	})
	$('div.delete_week').dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Delete Week(s)?",
		buttons: {
			"Delete": function(){
				var path = "/ajax/delete_week.php?id="+$(this).attr('id');
				$.get(path, function(){
					location.href = location.href;
				})
			},
			"Cancel": function(){
				$(this).dialog('close');
			}
		}
	})

// New Week Button
	$('button.new').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_week.php';
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
	$('button.new_calender').button({
		icons :{primary: "ui-icon-plusthick"}
	}).click(function(){
		var path = '/ajax/new_calender.php';
		$('div.new_calender').load(path).dialog('open');
	})
	 $(":submit").;
})

</script>
