<?php

// Include classes
include_once('tbs_class.php'); // Load the TinyButStrong template engine
include_once('tbs_plugin_opentbs.php'); // Load the OpenTBS plugin
include('includes/login.inc.php');

// Initalize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// ------------------------------
// Prepare some data for the demo
// ------------------------------

// Retrieve the user name to display

$query="SELECT
	unit.course as course_name, 
	unit.name as unit_name, 
	SUBSTRING(class.session_num, 5,1) as session,
	SUBSTRING(class.session_num, 1, 4) as year,
	unit.std_units,
	unit.level,
	class_code,
	unit.unit_code,
	CONCAT(teacher.fname, ' ', teacher.lname) as teacher_name,
	goals,
	content 
FROM class JOIN `unit` on class.unit_code = unit.unit_code JOIN teacher on class.teacher_code = teacher.username where unit.unit_code=? LIMIT 1";
$stmt=$mysqli->prepare($query);
$unit='20999';
$stmt->bind_param('s', $unit);
$stmt->execute();
$data=bind_result_array($stmt);
$stmt->fetch();

$unit_goals = txt2array($data['goals']);
$unit_content = txt2array($data['content']);

$stmt->close();

$assessment = array();


$query="SELECT * FROM assessment_item where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s', $data['unit_code']);
$stmt->execute();
$i=0;
do {
	$assessment[$i]=bind_result_array($stmt);
	$i++;
}
while($stmt->fetch());
unset($assessment[$i-1]);  //For some reason, the last element of the array is blank. This removes that element.
$stmt->close();

$query="SELECT * FROM tt_period where current = 1 LIMIT 1";
$stmt=$mysqli->prepare($query);
$stmt->execute();
$tt_period=bind_result_array($stmt);
$stmt->fetch();
$stmt->store_result();
$stmt->close();
$tt_period['start_date'] = new DateTime($tt_period['start_date']);
$tt_period['end_date'] = new DateTime($tt_period['end_date']);

$query="SELECT * FROM tt_period where name=? LIMIT 1";
$stmt=$mysqli->prepare($query);
$name=$tt_period['name'].'_holiday';
$stmt->bind_param('s', $name);
$stmt->execute();
$holiday=bind_result_array($stmt);
$stmt->fetch();
$stmt->store_result();
$stmt->close();
$holiday['start_date'] = new DateTime($holiday['start_date']);
$holiday['end_date'] = new DateTime($holiday['end_date']);


$curdate=$tt_period['start_date'];
$i=0;
$week=1;
while($curdate < $tt_period['end_date']){
	
	$query="SELECT * FROM `unit_calendar` where `unit_code` = ? AND `week_num` = ? LIMIT 1";
	$stmt=$mysqli->prepare($query);
	echo $mysqli->error;
	$stmt->bind_param('si', $unit, $i);
	$stmt->execute();
	$row[$i]=bind_result_array($stmt);
	$stmt->fetch();
	if($curdate >= $holiday['start_date'] && $curdate <= $holiday['end_date']){
		$calendar[$i]['week']="HOLIDAYS";
		$calendar[$i]['notes']="";
		$calendar[$i]['topics']="";

	}
	else {
		$calendar[$i]['week']="Week $week";
		$week++;
		$calendar[$i]['topics']=$row[$i]['topics'];
		$calendar[$i]['notes']=$row[$i]['notes'];
	}
	
	
	$calendar[$i]['dates']=$curdate->format('d M'); //Should start on Monday
	$curdate->add(new DateInterval('P4D')); //Should be Friday, end of week
	$calendar[$i]['dates'] .= ' - '.$curdate->format('d M'); //Should start on Monday
	$curdate->add(new DateInterval('P3D')); // Next  monday
	

	$stmt->close();
	
	$i++;
}


// -----------------
// Load the template
// -----------------

$template = 'unit_outline_templates/default.docx';
$TBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).

// Merge data in the body of the document
//$TBS->MergeBlock('a,b', $data);
$TBS->MergeBlock('data', array($data));

$TBS->MergeBlock('unit_goals', $unit_goals);
$TBS->MergeBlock('unit_content', $unit_content);
$TBS->MergeBlock('assessment', $assessment);
$TBS->MergeBlock('calendar', $calendar);

// -----------------
// Output the result
// -----------------

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
if ($save_as==='') {
	// Output the result as a downloadable file (only streaming, no data saved in the server)
	$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
} else {
	// Output the result as a file on the server
	$TBS->Show(OPENTBS_FILE+TBS_EXIT, $output_file_name); // Also merges all [onshow] automatic fields.
}

