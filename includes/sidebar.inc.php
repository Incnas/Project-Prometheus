<head>
<link rel="stylesheet" type="text/css" href="/css/Sidebar.css">
</head>


<? 
if($_SESSION['user']['role']=='student'){
	if(curPageName()=='index.php'){
?>
	<div class="sidebar">
		<div id="upcoming_assessment">
			<h4>Upcoming Assessment</h4>
			<p>Pull any assessment out/due in the next two weeks</p>
		</div>

		<div id="upcoming_events">
			<h4>Upcoming School Events</h4>
			<p>To be implemented once the news page has been created</p>
		</div>
	</div>
<?
	}
}
?>

