<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

$QUERY = "SELECT * FROM user WHERE ID=?"; 
$stmt=$mysqli->prepare($QUERY);
$stmt->bind_param("i", $_GET["id"]);
$stmt->execute();
$row=bind_result_array($stmt);
$stmt->fetch();

?>
<p>TODO: List Available Classes</p>
<p>Each class should be the same "Using PHP?"</p>
<xh4>CLASS NAME</h4>
<p>Teacher: <? echo $row['username']; ?></p>
<p>Assessments</p>

<p>TODO: Create Side-Bar</p>
<p>Sidebar should contain:</p>
<h4>Registered Classes</h4>
<h4>Upcoming Assessment</h4>
<h4>Upcoming School Events</h4>

<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
