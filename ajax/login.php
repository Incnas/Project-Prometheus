<?
//Ajax part of login script.

$reqauth = false;

include($_SERVER['DOCUMENT_ROOT'].'/includes/login.inc.php');
if(isset($_POST['username'])){	
	if ($stmt = $mysqli-> prepare("SELECT * FROM `user` where `username` = ? LIMIT 1")){
		$stmt-> bind_param("s", $_POST['username']);
		$stmt-> execute();
		$stmt-> store_result();
		$result=bind_result_array($stmt);
		if ($stmt->fetch()){
			if ($result['password'] == generateHash($_POST['password'], $result['password'])){
				// User is authenticated
				$_SESSION['authenticated']=true;
				$_SESSION['user']['name']=$result['username'];
				$_SESSION['user']['id']=$result['id'];
				if($result['role']=='admin') $_SESSION['user']['isadmin']=true;
				echo 1;
				exit;
			}

		}
		$stmt->close();
	}
}

echo 0;


  /*      
            if(isset($message)){
            switch($message){
            case "failed": echo '<p class="error">Username or password incorrect, please try again
                                    <br />
                                    <a href="/user_mgmt/forgot_password.php">Forgot Password?</a>
                                    </p>';
                break;
            case "logout": echo '<p class="error">You have been logged out</p>';
                break;
            case "timeout" : echo '<p class="error">You must login first</p>';
                break;
            default:
            }
            }
            ?>



if(isset($_GET['message'])) {$message=$_GET['message']; }
*/


?>