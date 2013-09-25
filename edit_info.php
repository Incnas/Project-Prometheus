<?
//Root index.php
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');
//include($_SERVER['DOCUMENT_ROOT'].'/includes/sidebar.inc.php');

$query = "SELECT * FROM class JOIN user ON class.teacher_code = user.username JOIN unit ON class.unit_code = unit.unit_code";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);
?>
<div class='section'>
<h4>Class Name</h4>
<h4>Class ID: </h4>
<h4>Lines: </h4>
<h4>Teachers: </h4>
<form name='input' action="html_form_action.asp" method="post">
<h4>Unit Goals:</h4>
<p>Note: Each New Line Is An Individual Entry</p>
<textarea>
Test Text Area. NOTE:THE SIZE IS CHANGABLE. NEEDS FIX
</textarea>
<h4>Content:</h4>
<p>Note: Each New Line Is An Individual Entry</p>
<textarea>
Test Text Area. NOTE:THE SIZE IS CHANGABLE. NEEDS FIX
</textarea>
<h4>Assessment Items:</h4>
<button type="reset" value="Reset">Reset</button>
<button type="button">Default</button>
<input type="submit" formaction="preview_template" value="Preview" />
<input type="submit" value="Submit" />
</form>
</div>
<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/footer.inc.php');
?>
