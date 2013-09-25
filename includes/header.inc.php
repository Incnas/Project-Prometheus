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

<link href="/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
<link href="/css/main.css" rel="stylesheet" type="text/css" />
<? if(isset($headparams)){echo $headparams;} ?>
</head>
<body>
<div class="container">
<div class="header">
<h1>Welcome to NOAH</h1>
<!--<img src="/images/header.png" />-->
</div>
<div class="title">
	Logged in as: <? echo $_SESSION['user']['name']; ?>
	<a href="/logout.php">Logout</a>
</div>
<div class="menu">
	<ul id="menu">
			<li><a href="/index.php">Home</a></li>
			<li><a href="/news.php">News</a></li>
			<li><a href="/class_lists.php">All Classes</a></li>
			<li><a href="/prophet.php">Prophet</a></li>
			<li><a href="/user.php">Settings</a></li>
			<? if($_SESSION['user']['isadmin']) echo '<li><a href="/admin/">Administration</a></li>'; ?>	
	</ul>
</div>
<div id="content">
