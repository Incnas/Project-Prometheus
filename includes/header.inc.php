<? 
//Main header page for website.

error_reporting(-1);

//Start page load time counter
$pageload = microtime(true);
include('login.inc.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><? if(isset($title)) echo $title; ?></title>
<script type="text/javascript" src="/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.js"></script>
<script type="text/javascript" src="/js/common.js"></script>
<script type="text/javascript" src="/js/change_css.js"></script>

<link href="/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/main.css" rel="stylesheet" type="text/css" />
<link href="/css/cssmenu.css" rel="stylesheet" type="text/css" />
<link href="/css/header.css" rel="stylesheet" type="text/css" />
<? if(isset($headparams)){echo $headparams;} ?>
</head>

<body>
<div class="header">
	<div id="title"><h1>Welcome to NOAH</h1></div>
	<!--<img src="/images/header.png" />-->
	<div id="user_title">Logged in as: <? echo $_SESSION['user']['name']; ?> <button class='logout'>Logout</button></div>
	<div id="cssmenu">
	<ul>
		<li><a href="/index.php">Home</a></li>
		<li><a href="/my_classes.php">My Classes</a></li>
		<li><a href="/class_lists.php">All Classes</a></li>
		<li><a href="/prophet.php">Prophet</a></li>
		<li><a href="/user.php">Settings</a></li>
		<? if($_SESSION['user']['role']=='admin') echo '<li><a href="/administration.php">Administration</a></li>'; ?>	
	</ul>
</div>
</div>
<div class="container">

<script>
$(function(){
	$('button.logout').button({
		//icons:{primary: "ui-icon-closethick"}
	}).click(function(){
		window.location.href='logout.php';
	});
})
$(document).ready(function(){
    $('#cssmenu a').each(function(index) {
        if(this.href.trim() == window.location)
            $(this).addClass("active");
    });
});
</script>

