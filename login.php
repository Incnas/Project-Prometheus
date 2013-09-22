<? 
//Main login page for unauthenticated users	
$reqauth=false;
include($_SERVER["DOCUMENT_ROOT"].'/includes/login.inc.php');

if(isset($_SESSION['authenticated']) && $_SESSION['authenticated']==true){
    header('Location: /index.php'); // User is already auth'd. Why are you here?
    exit;
}
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta charset="utf-8">

    <title>Prometheus: Login</title>
    
    <script type="text/javascript" src="/js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.10.3.custom.js"></script>
    <script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/login.js"></script>


    <link href="/css/redmond/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/css/basic.css">
    
</head>

<body>
    <div>
        <h1>PROMETHEUS</h1>

        <h2>Narrabundah College Course Manager.</h2>

        <noscript>
            <span style="color:red">
                Your browser does not support Javascript, an essential component of this site. Please use a browser that does.
            </span>
        </noscript>
        <span id="error" style="color:red">
             
        </span>
        <form id="login" method="" action="">
        	
            <p>Username: <input type="text" name="username" autofocus="autofocus" autocomplete="off" size="20"></p>

            <p>Password: <input type="password" name="password" size="20"></p>
            <button type="submit" id="submit">Login</button>
        </form>
        <!-- <p>New? <a href="/user/register.php">Register Here</a></p> -->
    </div>
</body>
</html>
