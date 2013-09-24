<? 
//Main header page for website.

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
<div class="sidebar">
<p>TODO: Create Side-Bar</p>
<p>Sidebar should contain:</p>
<h4>Registered Classes</h4>
<h4>Upcoming Assessment</h4>
<h4>Upcoming School Events</h4>
</div>
