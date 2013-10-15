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

function select_enum($col_name, $tbl_name, $mysqli)
{ 
	echo "<select name=\"$col_name\">"; 
	$stmt=$mysqli->prepare("SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '$tbl_name' AND COLUMN_NAME = '$col_name'");
	$stmt->execute();
	$stmt->bind_result($result);
	$stmt->fetch(); 
	$enumList = explode(",", str_replace("'", "", substr($result, 5, (strlen($result)-6))));
	foreach($enumList as $value) echo "<option value=\"$value\">$value</option>"; 
	echo "</select>";
}

function txt2array($input){
	$tmp = preg_split('/$\R?^/m', $input);
	foreach($tmp as $item){
		$output[]=array('text'=> trim($item));
	}
	return $output;
}
