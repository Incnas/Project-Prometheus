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
<h4><?=$row2['data']?></h4>
<h4><?=$row3['data']?></h4>

<button class="edit_session">Edit Session</button>
<button class="clear">Clear Calender</button>
<button class="new">Add Week(s)</button>

<!--Update Calender-->
<button class="update_calender">
Update Calender<?

$query4 = "SELECT * FROM calender WHERE day_num=0";
$stmt4=$mysqli->prepare($query4);
$stmt4->execute();
$stmt4->store_result();
$row4=bind_result_array($stmt4);
while($stmt4->fetch()){
	if($row4['type']=='Holiday'){
		$query5 = "UPDATE calender set type='Holiday', week_num=0 WHERE week_num=?";
		$stmt5=$mysqli->prepare($query5);
		$stmt5->bind_param('i', $row['week_num']);
		$stmt5->execute();
		$stmt5->close();
	}
}
?></button>
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
			<button class="date">
			<?if($row['day_num']!=0) {
				//echo $row['day_num'].' ';
				echo get_date($row3['data'], ($row['week_num']-1)*7+$row['day_num']-1)->format('d/M');
			}
			elseif($row['type']!='Holiday'){
				echo 'Week: '.$row['week_num'].' ';
			}
			if($row['type']!='School'){
				?></br><?
				echo $row['type'];
			}?>
			</button>
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
<div class="edit_session"></div>
<div class="new_week"></div>
<div class="clear_calender">Are you sure? This move is irreversable.</div>
<div class="delete_week">Are you sure?</div>
<div class="edit_date"></div>
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
				var path = "/ajax/delete_week.php";
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
//Edit Session Info
	$('button.edit_session').button({
		icons:{primary: "ui-icon-pencil"}
	}).click(function(){
		var path = '/ajax/edit_session.php';
		$('div.edit_session').
		load(path).
		dialog('open');
	});
	$('div.edit_session').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Edit Session",
		buttons: {
			"Update Session": function() {
				//Update assessment
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/edit_session.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	});
//Refresh Calender
	$('button.update_calender').button({
		icons:{primary: "ui-icon-arrowreturnthick-1-e"}
	}).click(function(){
		
	});

//Edit Date
	$('button.date').button({
		icons:{primary: "ui-icon-pencil"}
	}).click(function(){
		var path = '/ajax/edit_date.php?id='+$(this).attr('id');
		$('div.edit_date').
		load(path).
		dialog('open');
	});
	$('div.edit_date').dialog({
		autoOpen: false,
		height: 350,
		width: 400,
		modal: true,
		resizable: false,
		draggable: false,
		title: "Edit date",
		buttons: {
			"Edit Date": function() {
				//Update assessment
				var qstring=$(this).find('form').serialize();
				$(this).dialog({buttons: {"Loading....":function(){}}});
				$(this).load('/ajax/edit_date.php?'+qstring,'',function(){
					location.href = location.href;
				});
			}
		}
	});
	
//	 $(":submit").;
})

</script>
