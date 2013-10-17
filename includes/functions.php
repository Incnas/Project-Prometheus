<?
//File contains commonly used functions and

//function for generating and comparing password hashes
define('SALT_LENGTH', 9);
function generateHash($plainText, $salt = null)
{
    if ($salt === null)
    {
    	// generate random salt
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else
    {
    	// use salt from already hashed string
        $salt = substr($salt, 0, SALT_LENGTH);
    }

    return $salt . sha1($salt . $plainText);
}

function bind_result_array($stmt) //equivalent to fetch_assoc(), but for prepared statements - returns result of a stmt to an associative array.
{
    $meta = $stmt->result_metadata();
    $result = array();
    while ($field = $meta->fetch_field())
    {
        $result[$field->name] = NULL;
        $params[] = &$result[$field->name];
    }

    call_user_func_array(array($stmt, 'bind_result'), $params);
    return $result;
}

function td ($data, $class = NULL) //Generates a td element with optional class
{	
	if(isset($class)) echo '<td class="'.$class.'">';
	else echo '<td>';
	echo $data.'</td>';
	
}

function select_enum($col_name, $tbl_name, $mysqli) //Selects Enum data list from sql and creates dropdown box
{ 
	echo "<select name=\"$col_name\">"; 
	$stmt_u=$mysqli->prepare("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tbl_name' AND COLUMN_NAME = '$col_name'");
	$stmt_u->execute();
	$stmt_u->bind_result($result);
	$stmt_u->fetch(); 
	$enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result)-6))));
	foreach($enumList as $value) echo "<option value=\"$value\">$value</option>"; 
	echo "</select>";
}

function txt2array($input){	//Converts each new line into an individual array
	$tmp = preg_split('/$\R?^/m', $input);
	foreach($tmp as $item){
		$output[]=array('text'=> trim($item));
	}
	return $output;
}

function get_date($start_date, $s_interval){
	$interval = DateInterval::createFromDateString('1 day');
	//$period = new DatePeriod($start_date, $interval, $end_date);
	$end_date = DateTime::createFromFormat('Y-m-d', $start_date);
	for($i = 0; $i < $s_interval; $i++){
		$end_date->add($interval);			
	}
	return $end_date;
}

function get_school_week($week_num, $mysqli){ //Get School Week Number of Certain Week
	$stmt=$mysqli->prepare("SELECT * FROM calender WHERE week_num<'$week_num' AND day_num='0'");
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
	$school_week = 1;
	while($stmt->fetch()){
		if($row['type']!='Holiday'){
			$school_week++;
		}
	}
	return $school_week;
}
function update_calender($mysqli){
	$query = "SELECT * FROM calender WHERE day_num=0";
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
	//If Week is Holiday, Set all days to holiday
	while($stmt->fetch()){
		if($row['type']=='Holiday'){
			$query2 = "UPDATE calender set type='Holiday' WHERE week_num=?";
			$stmt2=$mysqli->prepare($query2);
			$stmt2->bind_param('i', $row['week_num']);
			$stmt2->execute();
			$stmt2->close();
		}
	}
	$stmt->close();
	//Ensure weeks drop down after a deleted week
	$query = "SELECT * FROM calender WHERE day_num='0' ORDER BY week_num DESC";
	$stmt=$mysqli->prepare($query);
	$stmt->execute();
	$stmt->store_result();
	$row=bind_result_array($stmt);
	$stmt->fetch();
	$week_num = $row['week_num'];
	while($stmt->fetch()){
		if($row['week_num']!=$week_num-1){
			$query="UPDATE calender set week_num='$week_num-1' WHERE week_num='$week_num'";
			$stmt2=$mysqli->prepare($query);
			$stmt2->execute();
			$stmt2->close();
			$stmt->data_seek(0);
		}
		$week_num = $row['week_num'];
	}
}



