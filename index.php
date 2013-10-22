<link href="/css/header.css" rel="stylesheet" type="text/css" />
<?
	//Root index.php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
?>
<div id="tabs">
	<ul>
		<li><a href="#news">News</a></li>
		<li><a href="#sporting">Sports</a></li>
		<li><a href="#calender">Calender</a></li>
		<li><a href="#timetable">Timetable</a></li>
	</ul>
	<div id="news">
		<button id="add_story">+ News</button>
<div class="datagrid">
		<table>
			<thead>
				<tr>
					<th>News Feed</th>
				</tr>
			</thead>
			<tbody>
            	<tr>
					<td>News 1</td>
				</tr>
				<tr>
					<td>News 2</td>
				</tr>
				<tr>
					<td>News 3</td>
				</tr>
				<tr>
					<td>News 4</td>
				</tr>
				<tr>
					<td>News 5</td>
				</tr>
				<tr>
					<td>News 6</td>
				</tr>
				<tr>
					<td>News 7</td>
				</tr>
				<tr>
					<td>News 8</td>
				</tr>
				<tr>
					<td>News 9</td>
				</tr>
				<tr>
					<td>News 10</td>
				</tr>		
			</tbody>
		</table>
</div>
	</div>
	<div id="sporting">
		<p>Put Sports Notices news here</p>
	</div>
	<div id="calender">
		<p>Put Calender here</p>
	</div>
	<div id="timetable">
		<p>Put Timetable here</p>
	</div>
	<?include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');?>
</div>

<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
</script>


