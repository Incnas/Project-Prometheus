<?
include($_SERVER['DOCUMENT_ROOT'].'/includes/header.inc.php');

$query="SELECT * FROM class JOIN teacher ON class.teacher_code = teacher.username JOIN unit ON class.unit_code = unit.unit_code where class_code=?";
$stmt=$mysqli->prepare($query);	
$stmt->bind_param('s', $_GET['class_code']);
$stmt->execute();
$stmt->store_result();
$row=bind_result_array($stmt);

$stmt->fetch();
print_r($row);

?>