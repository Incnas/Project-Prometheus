<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
?>
<div class='prophet'>
<h3>Warning this will take you off the NOAH site</h3>
<button onclick="window.location.href='index.php'">Cancel</button><button onclick="window.location.href='/www.prophetapp.com.au/narrabundah'">OK</button>
</div>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>

<script>
$(function(){
	$('button').button({
		//icons:{primary: "ui-icon-closethick"}
	}).click(function(){
	});
})
</script>
