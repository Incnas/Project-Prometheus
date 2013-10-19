<link href="/css/header.css" rel="stylesheet" type="text/css" />
<?
	//Root index.php
	include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
	include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');
?>
<div id="tabs">
	<ul>
		<li><a href="#news">News</a></li>
		<li><a href="#sporting">Sports</a></li>
		<li><a href="#calender">Calender</a></li>
		<li><a href="#timetable">Timetable</a></li>
	</ul>
	<div id="news">
		<p>Put school news here</p>
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
</div>

<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
<script>
$(function() {
	$( "#tabs" ).tabs();
});
</script>


