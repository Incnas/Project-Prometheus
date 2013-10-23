<?
//Displays form and updates assessment in db

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');

$query="UPDATE `unit` SET goals=?, content=? where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('sss', $_GET['goals'], $_GET['content'], $_GET['unit_code']);
$stmt->execute();
$stmt->close();




