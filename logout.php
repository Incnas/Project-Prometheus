<?
// Logs out user and destroys their session.
session_start();
session_destroy();
header('Location: index.php?login=logout');
?>