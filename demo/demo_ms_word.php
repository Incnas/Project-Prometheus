<?php

// Include classes
include_once('tbs_class.php'); // Load the TinyButStrong template engine
include_once('../tbs_plugin_opentbs.php'); // Load the OpenTBS plugin
include('../includes/login.inc.php');

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
	class_code,
	unit.unit_code,
	CONCAT(user.fname, ' ', user.lname) as teacher_name,
	goals,
	content 
FROM class JOIN `unit` on class.unit_code = unit.unit_code JOIN user on class.teacher_code = user.username where class.class_code=? LIMIT 1";
$stmt=$mysqli->prepare($query);
$class='626_3';
$stmt->bind_param('s', $class);
$stmt->execute();
$data=bind_result_array($stmt);
$stmt->fetch();


function txt2array($input){
	$tmp = preg_split('/$\R?^/m', $input);
	foreach($tmp as $item){
		$output[]=array('text'=> trim($item));
	}
	return $output;
}
$unit_goals = txt2array($data['goals']);
$unit_content = txt2array($data['content']);

$stmt->close();

$query="SELECT * FROM assessment_item where unit_code=?";
$stmt=$mysqli->prepare($query);
$stmt->bind_param('s', $data['unit_code']);
$stmt->execute();
$tmp = bind_result_array($stmt);
$assessment = array();
$stmt->fetch();
	//$assessment[] = $tmp;
	array_push($assessment, $tmp);
print_r($assessment);


exit();


//exit();
// -----------------
// Load the template
// -----------------

$template = '../unit_outline_templates/default.docx';
$TBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).

// Merge data in the body of the document
//$TBS->MergeBlock('a,b', $data);
$TBS->MergeBlock('data', array($data));

$TBS->MergeBlock('unit_goals', $unit_goals);
$TBS->MergeBlock('unit_content', $unit_content);
$TBS->MergeBlock('assessment', $assessment);


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





// A recordset for merging tables
/*$data = array();
$data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
$data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
$data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );
*/

// Other single data items
/*
$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;
$x_delete = 1;
*/		


// ----------------------
// Debug mode of the demo
// ----------------------
/*if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.
*/
// --------------------------------------------
// Merging and other operations on the template
// --------------------------------------------




/*
// Change chart series
$ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart
$SeriesNameOrNum = 'Series 2';
$NewValues = array( array('Category A','Category B','Category C','Category D'), array(3, 1.1, 4.0, 3.3) );
$NewLegend = "Updated series 2";
$TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);
*/
// Delete comments
//$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);



